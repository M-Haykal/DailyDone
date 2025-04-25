@extends('user.layouts.app')

@section('title', 'List Project')

@section('content')
    <div class="container">
        <div class="my-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <!-- Search Input with Instant Search -->
            <div class="flex-grow-1">
                <div class="input-group border rounded-pill px-2">
                    <span class="input-group-text bg-transparent">
                        <i class="material-symbols-rounded">search</i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search projects..."
                        id="projectSearch" value="{{ request('search') }}" aria-label="Search projects">
                </div>
            </div>

            <!-- Original Sort Dropdown -->
            <div class="input-group me-2" style="width: 180px">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle form-select-md mb-0" type="button"
                        id="dropdownSortButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('sort') ? ucfirst(request('sort')) : 'Sort by' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownSortButton">
                        <li><a class="dropdown-item" href="{{ request()->url() }}">All</a></li>
                        <li><a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'alphabetical', 'search' => request('search')]) }}">Alphabetical</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ request()->fullUrlWithQuery(['sort' => 'deadline', 'search' => request('search')]) }}">Deadline</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Add Project Button -->
            <button class="btn btn-success mb-0 d-flex align-items-center gap-1" data-bs-toggle="modal"
                data-bs-target="#createProject">
                <i class="material-symbols-rounded fs-5">add</i>
                Add Project
            </button>
        </div>

        <!-- Projects Grid -->
        <div class="row mt-4" id="projectsContainer">
            @forelse ($projects as $project)
                @if (\Carbon\Carbon::parse($project->end_date)->isFuture())
                    <div class="col-md-4 col-12 mb-4 project-card" data-aos="fade-up" data-aos-duration="1000"
                        data-project-name="{{ strtolower($project->name) }}">
                        @if (
                            $project->user_id == auth()->id() ||
                                $project->sharedUsers()->where('user_id', auth()->id())->exists())
                            <div class="card shadow-sm h-100">
                                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                    <h5 class="card-title mb-0">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $project->name }}
                                        </a>
                                    </h5>
                                    <a href="#" onclick="confirmDelete(event, {{ $project->id }})"
                                        class="text-danger" data-bs-toggle="tooltip" title="Delete project">
                                        <i class="material-symbols-rounded">delete</i>
                                    </a>
                                    <form id="delete-form-{{ $project->id }}" class="d-none"
                                        action="{{ route('projects.delete', $project->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                    </form>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">{{ Str::limit($project->description, 25) }}</p>
                                    <div style="width: 100%; background: #e0e0e0; border-radius: 5px;">
                                        <div
                                            style="height: 20px; border-radius: 5px; background: #4CAF50; width: {{ $project->progress() }}%">
                                            <span
                                                style="color: white; padding-left: 5px;">{{ $project->progress() }}%</span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="avatar-group">
                                            <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                data-bs-toggle="tooltip"
                                                title="Project Owner: {{ $project->owner->name }}">
                                                <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                    alt="{{ $project->owner->name }}" class="img-fluid">
                                            </a>
                                            @foreach ($project->sharedUsers as $user)
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip"
                                                    title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                                    <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                                        alt="user{{ $loop->index + 2 }}" class="img-fluid">
                                                </a>
                                            @endforeach
                                        </div>
                                        <span class="badge bg-light text-dark">
                                            <i class="material-symbols-rounded me-1"
                                                style="font-size: 1rem">calendar_today</i>
                                            {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @empty
                <div class="col-12 text-center py-5 no-projects">
                    <img src="{{ asset('img/data-empety.png') }}" alt="No projects found" class="img-fluid"
                        style="max-width: 300px">
                    <h4 class="mt-3 text-muted">No projects found</h4>
                    <p class="text-muted">Create your first project to get started</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($projects->count())
            <div class="d-flex justify-content-center">
                {{ $projects->appends(['search' => request('search'), 'sort' => request('sort')])->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Delete confirmation
        function confirmDelete(event, projectId) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + projectId).submit();
                }
            });
        }

        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Search functionality
            let searchTimer;
            const $searchInput = $('#projectSearch');
            const $projectCards = $('.project-card');
            const $noProjects = $('.no-projects');
            const $pagination = $('.pagination');

            // Instant search with debounce
            $searchInput.on('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    const searchTerm = $searchInput.val().toLowerCase();
                    let visibleCount = 0;

                    $projectCards.each(function() {
                        const $card = $(this);
                        const projectName = $card.data('project-name');
                        const matchesSearch = projectName.includes(searchTerm);

                        if (matchesSearch) {
                            $card.show();
                            visibleCount++;
                        } else {
                            $card.hide();
                        }
                    });

                    // Show/hide no projects message
                    if (visibleCount === 0) {
                        $noProjects.show();
                        $pagination.hide();
                    } else {
                        $noProjects.hide();
                        $pagination.show();
                    }

                    // Update URL without reload
                    const url = new URL(window.location.href);
                    if (searchTerm) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }
                    history.pushState({}, '', url.toString());
                }, 500);
            });

            // Initialize search if there's a search term
            if ($searchInput.val()) {
                $searchInput.trigger('input');
            }
        });
    </script>
@endsection
