@extends('user.layouts.app')

@section('title', 'Notes')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div
                class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center p-4 border-bottom">
                <h2 class="mb-3 mb-md-0 fw-bold text-dark">Your Notes</h2>
                <a href="{{ route('user.note.index') }}" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-plus me-2"></i>Create Note
                </a>
            </div>

            <div class="card-body p-0">
                @if ($notes->isEmpty())
                    <div class="text-center py-5 bg-light rounded-3">
                        <i class="bi bi-sticky-note-fill fs-1 text-muted mb-3"></i>
                        <h4 class="text-muted mb-4">No notes found</h4>
                        <a href="{{ route('user.note.index') }}" class="btn btn-primary px-4">
                            <i class="fas fa-plus me-2"></i>Create Note
                        </a>
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($notes->sortByDesc('updated_at') as $note)
                            <li
                                class="list-group-item list-group-item-action p-4 border-bottom transition-all hover-bg-light">
                                <a href="{{ route('user.note.index', $note->id) }}" class="text-decoration-none">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <h5 class="mb-2 fw-bold text-dark">{{ $note->title }}</h5>
                                            <p class="mb-0 text-muted">{!! Str::limit($note->content, 120, '...') !!}</p>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block mb-2">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $note->updated_at->diffForHumans() }}
                                            </small>
                                            <form id="delete-form-{{ $note->id }}"
                                                action="{{ url('/user/notes/' . $note->id . '/destroy') }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm delete-note"
                                                    data-id="{{ $note->id }}">
                                                    <i class="bi bi-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @if (!$notes->isEmpty())
                <div class="card-footer bg-white py-3 px-4 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Total {{ $notes->count() }} notes</small>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Delete note confirmation
            const deleteButtons = document.querySelectorAll('.delete-note');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const noteId = button.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'rounded-3 shadow-lg',
                            confirmButton: 'btn btn-primary px-4',
                            cancelButton: 'btn btn-outline-danger px-4'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${noteId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
