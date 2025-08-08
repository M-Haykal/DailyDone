@extends('user.layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container p-2">
        <div class="main-header bg-gradient-primary p-4 rounded-3 mb-5 shadow-sm">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
                <form action="{{ route('user.project') }}" method="GET" class="flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa-solid fa-magnifying-glass text-success"></i>
                        </span>
                        <input type="text" name="search" id="projectSearch" class="form-control border-start-0"
                            placeholder="Search projects..." value="{{ request('search') }}" aria-label="Search projects"
                            aria-describedby="searchHelp">
                    </div>
                    <div id="searchHelp" class="form-text visually-hidden">Type to search projects by name</div>
                </form>

                <!-- Sort Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-success dropdown-toggle w-100" type="button" id="dropdownSortButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('sort') ? ucfirst(request('sort')) : 'Sort by' }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownSortButton">
                        <li><a class="dropdown-item" href="{{ route('user.project') }}">All</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('user.project', ['sort' => 'alphabetical', 'search' => request('search')]) }}">Alphabetical</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('user.project', ['sort' => 'deadline', 'search' => request('search')]) }}">Deadline</a>
                        </li>
                    </ul>
                </div>

                <!-- Add Project Button -->
                <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#createProject">
                    <i class="fa-solid fa-plus"></i> Add Project
                </button>
            </div>
        </div>

        @include('user.modal.create-project')

        <!-- Projects Grid -->
        <div class="row mt-4" id="projectsContainer">
            @forelse ($projects as $project)
                @if (\Carbon\Carbon::parse($project->end_date)->isFuture())
                    <div class="col-md-4 col-12 mb-4 project-card" data-project-name="{{ strtolower($project->name) }}">
                        @if (
                            $project->user_id == auth()->id() ||
                                $project->sharedUsers()->where('user_id', auth()->id())->exists())
                            <div class="card shadow-sm h-100 transition-all hover:shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5 class="card-title mb-3">
                                            <a href="{{ route('projects.show', $project->slug) }}"
                                                class="text-decoration-none text-dark hover-primary">
                                                {{ $project->name }}
                                            </a>
                                        </h5>
                                        @if ($project->user_id == auth()->id())
                                            <a href="#" onclick="confirmDelete(event, {{ $project->id }})"
                                                class="text-danger" data-bs-toggle="tooltip" title="Delete project">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <form id="delete-form-{{ $project->id }}" class="d-none"
                                        action="{{ route('projects.delete', $project->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                    </form>

                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($project->description, 50) }}
                                    </p>

                                    <!-- Avatar Group -->
                                    <div class="avatar-stack mb-3">
                                        @foreach ($project->sharedUsers as $user)
                                            <a href="javascript:;" class="avatar rounded-circle" data-bs-toggle="tooltip"
                                                title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                                <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                                    alt="{{ $user->name }}"
                                                    class="img-fluid border border-2 border-white">
                                            </a>
                                        @endforeach
                                        <a href="javascript:;" class="avatar rounded-circle" data-bs-toggle="tooltip"
                                            title="Project Owner: {{ $project->owner->name }}">
                                            <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                alt="{{ $project->owner->name }}"
                                                class="img-fluid border border-2 border-white">
                                        </a>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress mb-3" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $project->progress() }}%"
                                            aria-valuenow="{{ $project->progress() }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                            {{ $project->progress() }}%
                                        </div>
                                    </div>

                                    <!-- Deadline -->
                                    <span class="badge bg-light text-dark">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @empty
                <div class="col-12 text-center py-5 no-projects">
                    <img src="{{ asset('img/data-empety.png') }}" alt="No projects found" class="img-fluid mb-3"
                        style="max-width: 250px;">
                    <h4 class="text-muted mb-2">No Projects Found</h4>
                    <p class="text-muted">Create your first project to get started!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($projects->count())
            <div class="d-flex justify-content-center mt-4">
                {{ $projects->appends(['search' => request('search'), 'sort' => request('sort')])->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event, projectId) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${projectId}`).submit();
                }
            });
        }

        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            const $searchInput = $('#projectSearch');
            const $projectCards = $('.project-card');
            const $noProjects = $('.no-projects');
            const $pagination = $('.pagination');
            let searchTimer;

            $searchInput.on('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    const searchTerm = $searchInput.val().trim().toLowerCase();
                    let visibleCount = 0;

                    $projectCards.each(function() {
                        const $card = $(this);
                        const projectName = $card.data('project-name').toLowerCase();
                        const matchesSearch = projectName.includes(searchTerm);

                        $card.toggle(matchesSearch);
                        if (matchesSearch) visibleCount++;
                    });

                    $noProjects.toggle(visibleCount === 0);
                    $pagination.toggle(visibleCount > 0);

                    const url = new URL(window.location);
                    if (searchTerm) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }
                    history.pushState({}, '', url);
                }, 300);
            });

            $searchInput.closest('form').on('submit', function(e) {
                e.preventDefault();
                const searchTerm = $searchInput.val().trim();
                const url = new URL(window.location);

                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                url.searchParams.delete('page');
                window.location = url.toString();
            });

            if ($searchInput.val().trim()) {
                $searchInput.trigger('input');
            }

            $('.project-card').hover(
                function() {
                    $(this).find('.card').addClass('shadow');
                },
                function() {
                    $(this).find('.card').removeClass('shadow');
                }
            );
        });
    </script>
@endsection
