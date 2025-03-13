@extends('user.layouts.app')

@section('title', 'List Project')

@section('content')
    <div class="container">
        <div class="my-3 d-flex align-items-center justify-content-between">
            <h3 class="mb-0 h4 font-weight-bolder me-auto">List Project Page</h3>
            <button class="btn btn-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#createProject">
                <i class="material-symbols-rounded">add</i>
                Add Project
            </button>
        </div>
        <div class="row">
            @foreach ($projects as $project)
                @if (\Carbon\Carbon::parse($project->end_date)->gt(now()->addDays(7)))
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="1000">
                        @if ($project->user_id == auth()->id() || $project->sharedUsers->contains(auth()->id()))
                            <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                                <div class="card shadow ">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $project->name }}</h5>
                                        <p class="card-text">{{ $project->description }}</p>
                                        <div class="avatar-group mt-3">
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Project Owner: {{ $project->owner->name }}">
                                                <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                    alt="{{ $project->owner->name }}" class="img-fluid">
                                            </a>
                                            @foreach ($project->sharedUsers as $user)
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                                    <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                                        alt="user{{ $loop->index + 2 }}" class="img-fluid">
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-success">Deadline :
                                        {{ \Carbon\Carbon::parse($project->end_date)->format('d F Y') }}</div>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
