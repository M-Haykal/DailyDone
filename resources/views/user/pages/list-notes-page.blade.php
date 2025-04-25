@extends('user.layouts.app')

@section('title', 'List Notes')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
            <h2 class="mb-3 mb-md-0 fw-bold">Your Notes</h2>
            <a href="{{ route('user.note.index') }}" class="btn btn-success mb-0">
                <i class="fas fa-plus me-2"></i>Create Note
            </a>
        </div>

        <div class="card-body p-0">
            @if ($notes->isEmpty())
                <div class="text-center py-5 bg-light">
                    <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted mb-3">No notes found</h4>
                    <a href="{{ route('user.note.index') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Create Note
                    </a>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach ($notes->sortByDesc('updated_at') as $note)
                        <a href="{{ route('user.note.index', $note->id) }}"
                            class="list-group-item list-group-item-action p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="me-3">
                                    <h5 class="mb-2 fw-semibold">{{ $note->title }}</h5>
                                    <p class="mb-0 text-muted">{!! Str::limit($note->content, 120) !!}</p>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block mb-1">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $note->updated_at->diffForHumans() }}
                                    </small>
                                    <form id="delete-form-{{ $note->id }}"
                                        action="{{ url('/user/notes/' . $note->id . '/destroy') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-note"
                                            data-id="{{ $note->id }}">
                                            <i class="far fa-trash-alt me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if (!$notes->isEmpty())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Total {{ $notes->count() }} notes</small>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete note confirmation
            const deleteButtons = document.querySelectorAll('.delete-note');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const noteId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
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
