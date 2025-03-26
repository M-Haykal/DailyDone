@extends('user.layouts.app')

@section('title', 'List Project')

@section('content')
    <div class="container">
        <div class="my-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <form method="GET" class="d-flex align-items-center mb-0">
                <div class="input-group me-2">
                    <input type="text" class="form-control" placeholder="Search projects..." name="search"
                        value="{{ request('search') }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary mb-0" type="submit" id="button-addon2">Button</button>
                </div>
                <div class="input-group mt-0 me-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle form-select-md mb-0" type="button"
                            id="dropdownSortButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('sort') ? ucfirst(request('sort')) : 'Sort by' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownSortButton">
                            <li><a class="dropdown-item" href="{{ request()->url() }}">All</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'alphabetical']) }}">Alphabetical</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ request()->fullUrlWithQuery(['sort' => 'deadline']) }}">Deadline</a></li>
                        </ul>
                    </div>
                </div>
            </form>
            <button class="btn btn-success text-decoration-none mb-0" data-bs-toggle="modal"
                data-bs-target="#createProject">
                <i class="material-symbols-rounded">add</i>
                Add Project
            </button>
        </div>
        <div class="row">
            @forelse ($projects as $project)
                @if (\Carbon\Carbon::parse($project->end_date)->isFuture())
                    <div class="col-md-4 col-12 mb-4" data-aos="fade-up" data-aos-duration="1000">
                        @if ($project->user_id == auth()->id() || $project->sharedUsers()->where('user_id', auth()->id())->exists())
                            <a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none">
                                <div class="card shadow">
                                    <div class="card-header d-flex g-2 justify-content-between">
                                        <h5 class="card-title">{{ $project->name }}</h5>
                                        <form id="delete-form-{{ $project->id }}"
                                            action="{{ route('projects.delete', $project->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                        </form>
                                        <a href="" onclick="confirmDelete({{ $project->id }})" class="text-danger">
                                            <i class="material-symbols-rounded">delete</i>
                                        </a>
                                    </div>
                                    <div class="card-body py-0 px-3">
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
            @empty
                <div class="data-empety">
                    <img src="{{ asset('img/data-empety.png') }}" alt="" srcset="" class="img-fluid">
                    <h1 class="text-center">Project not found</h1>
                </div>
            @endforelse

            <div class="d-flex justify-content-center">
                {{ $projects->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(projectId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Proyek yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + projectId).submit();
                }
            });
        }
    </script>
@endsection
