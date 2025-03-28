@extends('user.layouts.app')

@section('title', 'List Notes')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
                <h5 class="mb-3 mb-md-0 fw-bold text-primary">Your Notes</h5>
                <a href="{{ route('user.note.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create New Note
                </a>
            </div>

            <div class="card-body p-0">
                @if ($notes->isEmpty())
                    <div class="text-center py-5 bg-light">
                        <i class="fas fa-sticky-note fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted mb-3">No notes found</h4>
                        <a href="{{ route('user.note.index') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Note
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
                                        <span class="badge bg-light text-dark border">
                                            <i class="far fa-edit me-1"></i>Edit
                                        </span>
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
                        {{-- <a href="{{ route('user.note.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>Add New
                        </a> --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
