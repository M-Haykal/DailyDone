@extends('user.layouts.app')

@section('title', $project->name)

@section('content')
    <div class="min-vh-100"
        style="
        background-image: linear-gradient(rgba(0, 0, 0, 0.26), rgba(0,0,0,0.45)),
        url('{{ $project->background_project
            ? (file_exists(public_path('storage/bgProject/' . $project->background_project))
                ? asset('storage/bgProject/' . $project->background_project)
                : (file_exists(public_path('img/bgImg/' . $project->background_project))
                    ? asset('img/bgImg/' . $project->background_project)
                    : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'))
            : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80' }}');
        background-size: auto;
        background-position: center;">
        <div class="container p-2">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 d-flex justify-content-between">
                    <div class="detail-project">
                        <div class="detail-section d-flex align-item-center">
                            <h3 class="card-title fw-bold text-dark">{{ $project->name }}</h3>
                            <span>|</span>
                            <p class="text-muted mb-0">
                                {{ Str::limit($project->description, 150) }}
                                @if (strlen($project->description) > 150)
                                    <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#descriptionModal{{ $project->id }}">... Read more</a>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="action-project">
                        <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-sm-end my-2">
                            @if (auth()->id() == $project->user_id)
                                <button class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                                    data-bs-toggle="modal" data-bs-target="#shareProject">
                                    <i class="fa-solid fa-share-nodes"></i> Share
                                </button>
                                <a href="{{ route('user.tasklist.index', ['project_slug' => $project->slug]) }}"
                                    class="btn btn-success btn-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Add Task
                                </a>
                                @if ($project->status == 'archived')
                                    <a href="{{ route('projects.activate', $project) }}"
                                        class="btn btn-warning btn-sm d-flex align-items-center gap-2"
                                        onclick="event.preventDefault(); document.getElementById('activate-form{{ $project->id }}').submit();">
                                        <i class="fas fa-recycle"></i> Activate
                                    </a>
                                    <form id="activate-form{{ $project->id }}"
                                        action="{{ route('projects.activate', $project) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @elseif ($project->status == 'active')
                                    <a href="{{ route('projects.archive', $project) }}"
                                        class="btn btn-warning btn-sm d-flex align-items-center gap-2"
                                        onclick="event.preventDefault(); document.getElementById('archive-form{{ $project->id }}').submit();">
                                        <i class="fas fa-archive"></i> Archive
                                    </a>
                                    <form id="archive-form{{ $project->id }}"
                                        action="{{ route('projects.archive', $project) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                @endif
                                <button class="btn btn-dark btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                                    data-bs-target="#editBackgroundImage">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Background
                                </button>
                                <a href="{{ url('Chat') }}"
                                    class="btn btn-secondary btn-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-comment"></i> Chat
                                </a>
                            @elseif ($project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                <a href="{{ route('user.tasklist.index', ['project_id' => $project->id]) }}"
                                    class="btn btn-success btn-sm d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Add Task
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Description Modal -->
                @if (strlen($project->description) > 150)
                    <div class="modal fade" id="descriptionModal{{ $project->id }}" tabindex="-1"
                        aria-labelledby="descriptionModalLabel{{ $project->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="descriptionModalLabel{{ $project->id }}">
                                        {{ $project->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $project->description }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>



            <!-- Include Modals -->
            @include('user.modal.edit-permission')
            @include('user.modal.share-project')
            @include('user.modal.edit-background-image')
            @include('user.modal.profile-user')
            @include('user.modal.profile-owner')

            <div class="container-fluid py-3">
                <ul class="nav nav-fill nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#task-statistic"
                            role="tab" aria-controls="task-statistic" aria-selected="true"> Detail Project </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#list-task" role="tab"
                            aria-controls="list-task" aria-selected="false"> List Task </a>
                    </li>
                </ul>
                <div class="tab-content pt-5" id="tab-content">
                    <div class="tab-pane active" id="task-statistic" role="tabpanel" aria-labelledby="fill-tab-0">
                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="url-generate">
                                                <label for="share_url" class="form-label">
                                                    URL Berbagi
                                                    @if (session('permission_type'))
                                                        (Izin: {{ session('permission_type') }})
                                                    @endif
                                                </label>

                                                <div class="input-group">
                                                    <a href="{{ session('share_url') ?? '#' }}" target="_blank"
                                                        class="btn btn-primary {{ session('share_url') ? '' : 'disabled' }}">
                                                        Lihat Preview
                                                    </a>

                                                    <input type="text" id="share_url" class="form-control"
                                                        value="{{ session('share_url') ?? '' }}" readonly>

                                                    <button class="btn btn-success" onclick="copyToClipboard()">Salin
                                                        URL</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="card-title">
                                                <h5 class="fw-bold">User Project {{ $project->name }}</h5>
                                            </div>
                                            <div class="user-section">
                                                <div class="avatar-stack d-flex justify-content-end">
                                                    @if (auth()->id() == $project->user_id)
                                                        <span class="avatar"><a href=""
                                                                class="text-white text-decoration-none"
                                                                data-bs-toggle="modal" data-bs-target="#shareProject"
                                                                title="Add User"><i
                                                                    class="fa-solid fa-plus"></i></a></span>
                                                    @endif
                                                    @foreach ($project->sharedProjects as $shared)
                                                        @if ($shared->user)
                                                            @if (auth()->id() == $project->user_id)
                                                                <a href="javascript:;"
                                                                    class="avatar rounded-circle border border-2 border-white"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editPermission{{ $shared->id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    title="{{ $shared->user->name }} ({{ $shared->permissions }}) - Click to edit">
                                                                    <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                                                                        alt="{{ $shared->user->name }}"
                                                                        class="img-fluid">
                                                                </a>
                                                            @else
                                                                <a href="javascript:;"
                                                                    class="avatar rounded-circle border border-2 border-white"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#profileModal{{ $shared->user->id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    title="{{ $shared->user->name }} ({{ $shared->permissions }})">
                                                                    <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                                                                        alt="{{ $shared->user->name }}"
                                                                        class="img-fluid">
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    <span class="avatar rounded-circle border border-2 border-white"
                                                        data-bs-placement="bottom"
                                                        title="Project Owner: {{ $project->owner->name }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ownerProfileModal{{ $project->owner->id }}"
                                                        style="cursor: pointer;">
                                                        <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                            alt="{{ $project->owner->name }}" class="img-fluid">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0 fw-bold">{{ $project->name }} — Status Task</h5>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="statusBarChart" height="120"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="list-task" role="tabpanel" aria-labelledby="fill-tab-1">
                        <div class="row flex-nowrap overflow-x-auto">
                            <!-- To Do Column -->
                            <div class="col-md-4 col-12 px-2 mb-3">
                                <div class="card bg-danger text-white shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                                        <h4 class="mb-0 fw-bold">To Do</h4>
                                        <i class="fa-solid fa-brain fs-4"></i>
                                    </div>
                                </div>
                                <ul id="exampleLeft" class="list-group list-group-flush mt-2 border-0">
                                    @forelse ($project->taskLists->where('status', 'pending') as $taskList)
                                        <li class="card list-group-item bg-white shadow-sm rounded-3 mb-2 border border-2 border-danger"
                                            data-id="{{ $taskList->id }}">
                                            <div
                                                class="card-header bg-transparent border-bottom border-danger d-flex justify-content-between align-items-center py-2 px-3">
                                                <h5 class="mb-0 text-dark fw-semibold text-truncate"
                                                    title="{{ $taskList->list_items }}">
                                                    {{ Str::limit($taskList->list_items, 20) }}
                                                </h5>
                                                <div class="action">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-dark p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.detailList', ['slug' => $project->slug, 'idTaskList' => $taskList->id]) }}">
                                                                    Detail
                                                                </a>
                                                            </li>
                                                            @if (auth()->id() == $project->user_id ||
                                                                    $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.tasklist.viewEdit', ['slug' => $project->slug, 'idTaskList' => $taskList->id]) }}">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        class="dropdown-item"
                                                                        onclick="event.preventDefault(); document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                                        Hapus
                                                                    </a>
                                                                    <form id="delete-task-{{ $taskList->id }}"
                                                                        action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        method="POST" class="d-none">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <h5>
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                    <span>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d M Y') }}</span>
                                                </h5>
                                                <h5>
                                                    <i
                                                        class="fa-solid fa-flag fs-5 text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}"></i>
                                                    <span>{{ ucfirst($taskList->priority) }}</span>
                                                </h5>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center text-muted my-3">No tasks</p>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- In Progress Column -->
                            <div class="col-md-4 col-12 px-2 mb-3">
                                <div class="card bg-warning text-white shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                                        <h4 class="mb-0 fw-bold">In Progress</h4>
                                        <i class="fa-solid fa-spinner fs-4"></i>
                                    </div>
                                </div>
                                <ul id="exampleMiddle" class="list-group list-group-flush mt-2 border-0">
                                    @forelse ($project->taskLists->where('status', 'in_progress') as $taskList)
                                        <li class="card list-group-item bg-white shadow-sm rounded-3 mb-2 border border-2 border-warning"
                                            data-id="{{ $taskList->id }}">
                                            <div
                                                class="card-header bg-transparent border-bottom border-warning d-flex justify-content-between align-items-center py-2 px-3">
                                                <h5 class="mb-0 text-dark fw-semibold text-truncate"
                                                    title="{{ $taskList->list_items }}">
                                                    {{ Str::limit($taskList->list_items, 20) }}
                                                </h5>
                                                <div class="action">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-dark p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.detailList', ['slug' => $project->slug, 'idTaskList' => $taskList->id]) }}">
                                                                    Detail
                                                                </a>
                                                            </li>
                                                            @if (auth()->id() == $project->user_id ||
                                                                    $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('user.tasklist.viewEdit', ['slug' => $project->slug, 'idTaskList' => $taskList->id]) }}">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        class="dropdown-item"
                                                                        onclick="event.preventDefault(); document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                                        Hapus
                                                                    </a>
                                                                    <form id="delete-task-{{ $taskList->id }}"
                                                                        action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        method="POST" class="d-none">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <h5>
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                    <span>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d M Y') }}</span>
                                                </h5>
                                                <h5>
                                                    <i
                                                        class="fa-solid fa-flag fs-5 text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}"></i>
                                                    <span>{{ ucfirst($taskList->priority) }}</span>
                                                </h5>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center text-muted my-3">No tasks</p>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Completed Column -->
                            <div class="col-md-4 col-12 px-2 mb-3">
                                <div class="card bg-success text-white shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                                        <h4 class="mb-0 fw-bold">Completed</h4>
                                        <i class="fa-solid fa-circle-check fs-4"></i>
                                    </div>
                                </div>
                                <ul id="exampleRight" class="list-group list-group-flush mt-2 border-0">
                                    @forelse ($project->taskLists->where('status', 'completed') as $taskList)
                                        <li class="card list-group-item bg-white shadow-sm rounded-3 mb-2 border border-2 border-success"
                                            data-id="{{ $taskList->id }}">
                                            <div
                                                class="card-header bg-transparent border-bottom border-success d-flex justify-content-between align-items-center py-2 px-3">
                                                <h5 class="mb-0 text-dark fw-semibold text-truncate"
                                                    title="{{ $taskList->list_items }}">
                                                    {{ Str::limit($taskList->list_items, 20) }}
                                                </h5>
                                                <div class="action">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-dark p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-solid fa-bars"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('user.detailList', ['slug' => $project->slug, 'idTaskList' => $taskList->id]) }}">
                                                                    Detail
                                                                </a>
                                                            </li>
                                                            @if (auth()->id() == $project->user_id ||
                                                                    $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                                                <li>
                                                                    <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        class="dropdown-item"
                                                                        onclick="event.preventDefault(); document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                                        Hapus
                                                                    </a>
                                                                    <form id="delete-task-{{ $taskList->id }}"
                                                                        action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                                        method="POST" class="d-none">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <h5>
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                    <span>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d M Y') }}</span>
                                                </h5>
                                                <h5>
                                                    <i
                                                        class="fa-solid fa-flag fs-5 text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}"></i>
                                                    <span>{{ ucfirst($taskList->priority) }}</span>
                                                </h5>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center text-muted my-3">No tasks</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if (session('share_url'))
        <div class="toast-container bottom-0 end-0 p-3">
            <div class="toast show fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex gap-4">
                        <span class="text-primary"><i class="fa-solid fa-circle-info fa-lg"></i></span>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <span class="fw-semibold">
                                URL ini memberikan akses
                                <strong>{{ session('permission_type') }}</strong>.
                                Untuk membuat URL dengan permission berbeda, generate ulang
                                dengan memilih akses yang diinginkan.
                            </span>
                            <button type="button" class="btn-close btn-close-sm btn-close-black ms-auto"
                                data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Sortable(document.getElementById("exampleLeft"), {
                group: {
                    name: 'shared',
                    pull: true,
                    put: false
                },
                animation: 150
            });

            new Sortable(document.getElementById("exampleMiddle"), {
                group: {
                    name: 'shared',
                    pull: true,
                    put: true
                },
                animation: 150
            });

            new Sortable(document.getElementById("exampleRight"), {
                group: {
                    name: 'shared',
                    pull: false,
                    put: false
                },
                animation: 150
            });
        });
    </script>
    <script>
        var canEdit = @json(auth()->id() == $project->user_id ||
                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists());

        document.addEventListener("DOMContentLoaded", function() {

            function updateTaskStatus(taskId, status) {
                if (!canEdit) return;

                fetch(`{{ url('/user/tasklist') }}/${taskId}/update-status`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content")
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response:", data);
                    })
                    .catch(error => console.error("Error:", error));
            }

            function updateTaskColor(taskItem, status) {
                taskItem.classList.remove("border-danger", "border-warning", "border-success");

                if (status === "pending") {
                    taskItem.classList.add("border-danger", "text-white");
                } else if (status === "in_progress") {
                    taskItem.classList.add("border-warning", "text-white");
                } else if (status === "completed") {
                    taskItem.classList.add("border-success", "text-white");
                }
            }

            function initializeSortable(containerId, status) {
                if (!canEdit) return;

                new Sortable(document.getElementById(containerId), {
                    group: "shared",
                    animation: 150,
                    onAdd: function(evt) {
                        let taskItem = evt.item;
                        let taskId = taskItem.getAttribute("data-id");

                        if (!taskId) {
                            console.error("Task ID tidak ditemukan!");
                            return;
                        }

                        updateTaskStatus(taskId, status);
                        updateTaskColor(taskItem, status);
                    }
                });
            }

            document.querySelectorAll(".border-status").forEach(item => {
                let status = item.closest("ul").id === "exampleLeft" ? "pending" :
                    item.closest("ul").id === "exampleMiddle" ? "in_progress" : "completed";
                updateTaskColor(item, status);
            });

            initializeSortable("exampleLeft", "pending");
            initializeSortable("exampleMiddle", "in_progress");
            initializeSortable("exampleRight", "completed");
        });

        function confirmDeleteAccess(sharedProjectId) {
            Swal.fire({
                title: 'Delete Access?',
                text: "Are you sure you want to delete this access?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAccessForm' + sharedProjectId).submit();
                }
            });
        }

        function copyToClipboard() {
            var copyText = document.getElementById("share_url");
            var url = copyText.value;
            var permissionType = "{{ session('permission_type', 'view') }}";

            if (!url) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum Ada URL',
                    text: 'Silakan generate URL terlebih dahulu.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            navigator.clipboard.writeText(url)
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'URL Disalin',
                        text: 'URL dengan izin ' + permissionType + ' telah disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false
                    });
                })
                .catch(err => {
                    console.error('Gagal menyalin teks: ', err);
                });
        }



        document.querySelectorAll('.template-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const imgSrc = this.parentElement.querySelector('img').src;
                    document.getElementById('previewImageLarge').src = imgSrc;
                    $('#previewModal').modal('show');
                }
            });
        });

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            const dropArea = e.currentTarget;
            dropArea.classList.remove('border-danger');

            const fileInput = document.getElementById('background_project');
            fileInput.files = e.dataTransfer.files;
            previewImage({
                target: fileInput
            });
        }

        function previewImage(event) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            if (event.target.files && event.target.files[0]) {
                // Validate file size (max 2MB)
                if (event.target.files[0].size > 2 * 1024 * 1024) {
                    alert('File size should not exceed 2MB');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    // Show small preview in upload tab
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded border';
                    img.style.maxHeight = '150px';
                    previewContainer.appendChild(img);

                    // Show large preview in preview modal
                    document.getElementById('previewImageLarge').src = e.target.result;
                    $('#previewModal').modal('show');
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function submitBackground() {
            const selectedTemplate = document.querySelector('input[name="background_option"]:checked');
            const form = document.getElementById('uploadForm');

            if (selectedTemplate) {
                const value = selectedTemplate.value.replace('template_', '');
                const dynamicForm = document.createElement('form');

                dynamicForm.method = 'POST';
                dynamicForm.action = form.action;
                dynamicForm.enctype = 'multipart/form-data';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';

                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = '_token';
                tokenInput.value = document.querySelector('input[name="_token"]').value;

                const bgInput = document.createElement('input');
                bgInput.type = 'hidden';
                bgInput.name = 'background_project';
                bgInput.value = value;

                dynamicForm.appendChild(methodInput);
                dynamicForm.appendChild(tokenInput);
                dynamicForm.appendChild(bgInput);

                document.body.appendChild(dynamicForm);
                dynamicForm.submit();
            } else {
                form.submit();
            }
        }

        function removeBackground() {
            if (confirm('Are you sure you want to remove current background?')) {
                fetch(`{{ route('user.project.removeBackground', $project->id) }}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
            }
        }

        document.getElementById('drop-area').addEventListener('click', () => {
            document.getElementById('background_project').click();
        });
    </script>
@endsection
