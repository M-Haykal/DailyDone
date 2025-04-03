@extends('user.layouts.app')

@section('title', 'Archive')

@section('content')
    <div class="container py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Archive Projects</h2>
            <span class="badge bg-light text-dark fs-6">
                <i class="fas fa-archive me-1"></i>{{ $projects->count() }} archive
            </span>
        </div>

        <!-- Projects Grid -->
        @if ($projects->isEmpty())
            <div class="col-12 text-center py-5 no-projects">
                <img src="{{ asset('img/data-empety.png') }}" alt="No projects in archive" class="img-fluid"
                    style="max-width: 300px">
                <h4 class="mt-3 text-muted">No projects in archive</h4>
                <p class="text-muted">Projects you archive will appear here</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($projects as $project)
                    @if ($project->user_id == auth()->id() || $project->sharedUsers->contains(auth()->id()))
                        <div class="col" data-aos="fade-up" data-aos-duration="600">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0 text-truncate pe-2">{{ $project->name }}</h5>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                            <i class="fas fa-archive me-1"></i>Archived
                                        </span>
                                    </div>

                                    <p class="card-text text-muted mb-3">{{ Str::limit($project->description, 100) }}</p>

                                    <!-- Members Avatars -->
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                        <div class="d-flex">
                                            <div class="position-relative me-2">
                                                <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                    class="rounded-circle border border-white" width="32" height="32"
                                                    data-bs-toggle="tooltip" title="Owner: {{ $project->owner->name }}">
                                            </div>
                                            @foreach ($project->sharedUsers->take(3) as $user)
                                                <div class="position-relative" style="margin-left: -10px;">
                                                    <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                                        class="rounded-circle border border-white" width="32"
                                                        height="32" data-bs-toggle="tooltip"
                                                        title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                                </div>
                                            @endforeach
                                            @if ($project->sharedUsers->count() > 3)
                                                <div class="position-relative bg-light rounded-circle border border-white d-flex align-items-center justify-content-center"
                                                    style="width: 32px; height: 32px; margin-left: -10px;">
                                                    <small
                                                        class="text-muted">+{{ $project->sharedUsers->count() - 3 }}</small>
                                                </div>
                                            @endif
                                        </div>

                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            View <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Due {{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}
                                        </small>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($project->end_date)->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
