@extends('user.layouts.app')

@section('title', 'Notes')

@section('content')
    <style>
        #saveStatus {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
            display: inline-flex !important;
            align-items: center;
            padding: 5px 10px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        }

        #saveStatus.bg-danger {
            background-color: #dc3545 !important;
        }

        #saveStatus.bg-warning {
            background-color: #ffc107 !important;
        }

        #saveStatus.bg-info {
            background-color: #17a2b8 !important;
        }

        #saveSpinner {
            display: none;
        }

        #saveStatus.saving #saveSpinner {
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 my-2">
            <div class="card p-3">
                <div id="saveStatus" class="position-absolute top-0 end-0 mt-2 me-3" style="display: none; z-index: 1000;">
                    <span class="badge bg-secondary" id="statusText"></span>
                    <div class="spinner-border spinner-border-sm text-light ms-1" id="saveSpinner" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span id="lastSavedTime" class="ms-1 small"></span>
                </div>
                <form id="noteForm">
                    @csrf
                    <input type="hidden" id="note_id" value="{{ $note->id ?? '' }}">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $note->title ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" style="width: 100%;" required>{{ $note->content ?? '' }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back to List</a>
                        @if (isset($note))
                            <button type="button" class="btn btn-danger" id="clearNote">Clear Input</button>
                        @else
                            <button type="button" class="btn btn-danger" id="clearNote">Clear Input</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
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

            ClassicEditor
                .create(document.querySelector('#content'))
                .then(instance => {
                    editor = instance;

                    editor.model.document.on('change:data', () => {
                        handleContentChange();
                    });
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

                        clearTimeout(typingTimer);
                        typingTimer = setTimeout(saveNote, delay);
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'Connection error';
                        showStatus('Failed to save', 'bg-danger');
                        showToast('Error: ' + errorMessage, 'error');

                        isTyping = true;

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

            function handleContentChange() {
                clearTimeout(typingTimer);

                if (!isTyping) {
                    showStatus('Editing...', 'bg-info');
                    isTyping = true;
                }

                const title = $('#title').val();
                const content = editor ? editor.getData() : $('#content').val();

                if (title && content) {
                    typingTimer = setTimeout(() => {
                        isTyping = false;
                        saveNote();
                    }, delay);
                }
            }

            $('#clearNote').on('click', function() {
                if (confirm("Are you sure you want to clear all input?")) {
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
                alert(type.toUpperCase() + ': ' + message);

                if (type === 'success') {
                    HotToast.success(message, {
                        position: 'top-right',
                        duration: 3000
                    });
                } else if (type === 'error') {
                    HotToast.error(message, {
                        position: 'top-right',
                        duration: 5000
                    });
                } else {
                    HotToast(message, {
                        position: 'top-right',
                        duration: 4000
                    });
                }

            }

            setInterval(() => {
                if ((editor && editor.getData()) || $('#title').val()) {
                    saveNote();
                }
            }, 30000);
        });
    </script>
@endsection
