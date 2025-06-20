@extends('user.layouts.app')

@section('title', 'Notes')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .full-screen-container {
            min-height: calc(100vh - 56px);
            /* Adjust for navbar height */
            display: flex;
            flex-direction: column;
            padding: 0;
        }

        .note-form {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .note-title {
            font-size: 2rem;
            border: none;
            border-bottom: 1px solid #dee2e6;
            border-radius: 0;
            padding: 1rem 1.5rem;
            background: transparent;
        }

        .note-title:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        .note-content {
            flex-grow: 1;
            border: none;
            border-radius: 0;
            padding: 1.5rem;
            resize: none;
            font-size: 1.1rem;
            background: transparent;
        }

        .note-content:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        #saveStatus {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
            display: inline-flex !important;
            align-items: center;
            padding: 8px 16px;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            font-size: 0.9rem;
        }

        #saveStatus.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        #saveStatus.fade-out {
            opacity: 0;
            transform: translateY(-5px);
        }

        #saveStatus.bg-success {
            background-color: #28a745 !important;
            color: white;
        }

        #saveStatus.bg-danger {
            background-color: #dc3545 !important;
            color: white;
        }

        #saveStatus.bg-warning {
            background-color: #ffc107 !important;
            color: #212529;
        }

        #saveStatus.bg-info {
            background-color: #17a2b8 !important;
            color: white;
        }

        #saveSpinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
        }

        #saveStatus.saving #saveSpinner {
            display: inline-block;
        }

        .action-buttons {
            padding: 1rem 1.5rem;
            background: #fff;
            border-top: 1px solid #dee2e6;
        }
    </style>
    <div class="container-fluid full-screen-container">
        <div id="saveStatus" class="position-fixed top-0 end-0 mt-3 me-3" style="z-index: 1050; display: none;">
            <span class="badge bg-secondary" id="statusText"></span>
            <div class="spinner-border spinner-border-sm ms-2" id="saveSpinner" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span id="lastSavedTime" class="ms-2 small"></span>
        </div>
        <form id="noteForm" class="note-form">
            @csrf
            <input type="hidden" id="note_id" value="{{ $note->id ?? '' }}">
            <input type="text" class="form-control note-title" id="title" name="title"
                value="{{ $note->title ?? '' }}" placeholder="Note Title" required>
            <textarea class="form-control note-content" id="content" name="content" required>{{ $note->content ?? '' }}</textarea>
            <div class="action-buttons d-flex justify-content-between align-items-center">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">Back to List</a>
                <button type="button" class="btn btn-outline-danger px-4" id="clearNote">Clear Input</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let typingTimer;
            const delay = 1000;
            let editor;
            let isSaving = false;
            let isTyping = false;
            let lastSavedTime = null;

            // Initialize CKEditor
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'undo', 'redo'
                    ],
                    placeholder: 'Start typing your note here...',
                    height: '100%',
                })
                .then(instance => {
                    editor = instance;
                    editor.model.document.on('change:data', handleContentChange);
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                    $('#content').show();
                });

            $('#title').on('input', handleContentChange);

            function handleContentChange() {
                clearTimeout(typingTimer);

                if (!isTyping) {
                    showStatus('Editing...', 'bg-info');
                    isTyping = true;
                }

                typingTimer = setTimeout(() => {
                    isTyping = false;
                    saveNote();
                }, delay);
            }

            function showStatus(text, bgClass = 'bg-secondary') {
                const $status = $('#saveStatus');
                $status.find('#statusText').text(text);
                $status.removeClass('fade-out bg-secondary bg-info bg-success bg-danger bg-warning')
                    .addClass('fade-in ' + bgClass);
                $status.fadeIn(200);
            }

            function showSavedStatus() {
                const $status = $('#saveStatus');
                lastSavedTime = new Date();
                $status.find('#statusText').text('Saved at ' + lastSavedTime.toLocaleTimeString());
                $status.removeClass('bg-secondary bg-info bg-danger bg-warning')
                    .addClass('bg-success');

                setTimeout(() => {
                    $status.addClass('fade-out');
                    setTimeout(() => {
                        if (!$status.hasClass('bg-info')) {
                            $status.fadeOut(200);
                        }
                    }, 1000);
                }, 1500);
            }

            function saveNote() {
                if (isSaving) {
                    setTimeout(saveNote, 500);
                    return;
                }

                const title = $('#title').val();
                const content = editor ? editor.getData() : $('#content').val();

                if (!title || !content) {
                    showStatus('Please fill all fields', 'bg-warning');
                    return;
                }

                isSaving = true;
                showStatus('Saving...', 'bg-secondary');
                $('#saveStatus').addClass('saving');

                const noteId = $('#note_id').val();
                const formData = {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    content: content
                };

                const url = noteId ? `/user/notes/${noteId}/update` : "/user/notes/store";
                const method = noteId ? "PUT" : "POST";

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        if (!noteId) {
                            $('#note_id').val(response.note.id);
                            window.history.pushState(null, null,
                                `/user/note/detail/${response.note.id}`);
                        }
                        showSavedStatus();
                        showToast('Changes saved', 'success');
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'Connection error';
                        showStatus('Failed to save', 'bg-danger');
                        showToast('Error: ' + errorMessage, 'error');

                        if (xhr.status === 422) {
                            clearTimeout(typingTimer);
                            typingTimer = setTimeout(saveNote, delay);
                        }
                    },
                    complete: function() {
                        isSaving = false;
                        $('#saveStatus').removeClass('saving');
                    }
                });
            }

            $('#clearNote').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will clear all input fields!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, clear it!',
                    customClass: {
                        popup: 'rounded-3 shadow-lg',
                        confirmButton: 'btn btn-primary px-4',
                        cancelButton: 'btn btn-outline-secondary px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#title').val('');
                        if (editor) {
                            editor.setData('');
                        } else {
                            $('#content').val('');
                        }

                        if (!"{{ isset($note) ? 'true' : 'false' }}") {
                            $('#note_id').val('');
                        }

                        showStatus('Input cleared', 'bg-info');
                        setTimeout(() => {
                            $('#saveStatus').fadeOut(200);
                        }, 1500);

                        showToast('All inputs have been cleared', 'info');
                    }
                });
            });

            window.addEventListener('offline', () => {
                showStatus('Offline - changes not saved', 'bg-warning');
                showToast('You are offline. Changes will be saved when you reconnect.', 'warning');
            });

            window.addEventListener('online', () => {
                showToast('Connection restored', 'success');
                if ($('#title').val() || (editor && editor.getData())) {
                    saveNote();
                }
            });

            function showToast(message, type = 'success') {
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: type === 'error' ? 5000 : type === 'info' ? 4000 : 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: `bg-${type} text-white rounded-3`
                    }
                });

                toast.fire({
                    icon: type,
                    title: message
                });
            }

            setInterval(() => {
                if ((editor && editor.getData()) || $('#title').val()) {
                    saveNote();
                }
            }, 30000);
        });
    </script>
@endsection
