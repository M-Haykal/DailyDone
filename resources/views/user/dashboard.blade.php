@extends('user.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="row overflow-x-hidden">
        <div class="d-flex align-items-center my-3">
            <h3 class="mb-0 h4 font-weight-bolder me-auto">Dashboard</h3>
            <p class="mb-0 ms-auto text-secondary">
                Plan, Do, Done.
            </p>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project List</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($projects as $project)
                            <li class="list-group-item">
                                @if ($project->user_id == auth()->id() || $project->sharedUsers()->where('user_id', auth()->id())->exists())
                                    <a class="nav-link text-dark d-flex justify-content-between align-items-center"
                                        href="{{ route('projects.show', $project->id) }}">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $project->name }}</div>
                                            {{ Str::limit($project->description, 20) }}
                                        </div>
                                        <div class="d-flex">
                                            <span class="badge text-bg-danger me-2" title="Pending">
                                                {{ $project->taskLists->where('status', 'pending')->count() }}</span>
                                            <span class="badge text-bg-warning me-2"
                                                title="In Progress">{{ $project->taskLists->where('status', 'in_progress')->count() }}</span>
                                            <span class="badge text-bg-success" title="Completed">
                                                {{ $project->taskLists->where('status', 'completed')->count() }}</span>
                                        </div>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                        <div class="pagination my-3 justify-content-center">
                            {{ $projects->links('pagination::bootstrap-4') }}
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
