@extends('user.layouts.app')

@section('title', 'List Notes')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Your Notes</h5>
            <a href="{{ route('user.note.index') }}" class="btn btn-primary">Create New Note</a>
        </div>

        <div class="card-body">
            @if($notes->isEmpty())
                <div class="alert alert-info">No notes found. Create your first note!</div>
            @else
                <div class="list-group">
                    @foreach($notes->sortByDesc('updated_at') as $note)
                        <a href="{{ route('user.note.index', $note->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $note->title }}</h5>
                                <small class="text-body-secondary">{{ $note->updated_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($note->content, 100) }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
