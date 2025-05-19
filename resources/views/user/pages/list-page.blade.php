@extends('user.layouts.app')

@section('title', $project->name)

@section('content')

    <div class="page-header min-height-300 border-radius-xl mt-2"
        style="background-image: url('{{ $project->background_project
            ? (file_exists(public_path('storage/bgProject/' . $project->background_project))
                ? asset('storage/bgProject/' . $project->background_project)
                : (file_exists(public_path('img/bgImg/' . $project->background_project))
                    ? asset('img/bgImg/' . $project->background_project)
                    : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'))
            : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80' }}');
                background-size: cover;
                background-position: center;">
        <span class="mask  bg-gradient-dark  opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h1 class="mb-0 text-white">{{ $project->name }}</h1>
                    <p class="text-white m-auto">{{ $project->description }}</p>
                    <span class="text-white">{{ \Carbon\Carbon::parse($project->start_date)->format('d F Y') }} -
                        {{ \Carbon\Carbon::parse($project->end_date)->format('d F Y') }}</span>
                    <div class="d-grid gap-2 d-md-block">
                        @if (auth()->id() == $project->user_id)
                            <a class="btn btn-primary" href="#" role="button" data-bs-toggle="modal"
                                data-bs-target="#shareProject"><i class="material-symbols-rounded">share</i>Share</a>
                            <a href="{{ route('user.tasklist.index', ['project_id' => $project->id]) }}"
                                class="btn btn-success text-decoration-none">
                                <i class="material-symbols-rounded">add</i>
                                Add Task
                            </a>
                            @if ($project->status == 'archived')
                                <a href="{{ route('projects.activate', $project) }}" class="btn btn-warning"
                                    onclick="event.preventDefault(); document.getElementById('activate-form{{ $project->id }}').submit();">
                                    <i class="fas fa-recycle"></i> Reactivate
                                </a>
                                <form id="activate-form{{ $project->id }}"
                                    action="{{ route('projects.activate', $project) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            @elseif ($project->status == 'active')
                                <a href="{{ route('projects.archive', $project) }}" class="btn btn-warning"
                                    onclick="event.preventDefault(); document.getElementById('archive-form{{ $project->id }}').submit();">
                                    <i class="fas fa-archive"></i> Archive
                                </a>
                                <form id="archive-form{{ $project->id }}"
                                    action="{{ route('projects.archive', $project) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            @endif
                            <button class="position-absolute bottom-0 end-0 p-3 text-white btn btn-link" href=""
                                role="button" data-bs-toggle="modal" data-bs-target="#editBackgroundImage"><i
                                    class="material-symbols-rounded">edit</i></button>
                            <a href="{{ url('Chat') }}"
                                class="position-absolute bottom-0 start-0 p-3 text-white btn btn-link" role="button">
                                <i class="material-symbols-rounded">chat</i>
                            </a>
                        @elseif ($project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                            <a href="{{ route('user.tasklist.index', ['project_id' => $project->id]) }}"
                                class="btn btn-success text-decoration-none">
                                <i class="material-symbols-rounded">add</i>
                                Add Task
                            </a>
                        @endif
                    </div>
                    <div class="avatar-group mt-2">
                        <span class="avatar avatar-xs rounded-circle" data-bs-placement="bottom"
                            title="Project Owner: {{ $project->owner->name }}" data-bs-toggle="modal"
                            data-bs-target="#ownerProfileModal{{ $project->owner->id }}" style="cursor: pointer;">
                            <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                alt="{{ $project->owner->name }}">
                        </span>

                        @foreach ($project->sharedProjects as $shared)
                            @if ($shared->user)
                                @if (auth()->id() == $project->user_id)
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#editPermission{{ $shared->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="{{ $shared->user->name }} ({{ $shared->permissions }}) - Klik untuk edit">
                                        <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                                            alt="{{ $shared->user->name }}">
                                    </a>
                                @else
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="modal"
                                        data-bs-target="#profileModal{{ $shared->user->id }}" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom"
                                        title="{{ $shared->user->name }} ({{ $shared->permissions }})">
                                        <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                                            alt="{{ $shared->user->name }}">
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.modal.edit-permission')
    @include('user.modal.share-project')
    @include('user.modal.edit-background-image')
    @include('user.modal.profile-user')
    @include('user.modal.profile-owner')

    {{-- <img src="{{ $project->background_project
        ? (file_exists(public_path('storage/bgProject/' . $project->background_project))
            ? asset('storage/bgProject/' . $project->background_project)
            : (file_exists(public_path('img/bgImg/' . $project->background_project))
                ? asset('img/bgImg/' . $project->background_project)
                : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'))
        : 'https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80' }}"
        alt=""> --}}

    <div class="row my-3">
        <div class="col-md-4 my-2">
            <div class="card bg-danger">
                <div class="card-body d-flex justify-content-between align-items-center m-3 p-0">
                    <h4 class="mb-0 text-white">To Do</h4>
                    <i class="material-symbols-rounded text-white">neurology</i>
                </div>
            </div>
            <ul id="exampleLeft" class="list-group list-group-flush list-group-item-secondary">
                @forelse ($project->taskLists->where('status', 'pending') as $taskList)
                    <li class="card list-group-item list-items rounded my-2 border border-2 bg-white border-status shadow"
                        data-id="{{ $taskList->id }}">
                        <div
                            class="card-header bg-transparent border-bottom border-status d-flex justify-content-between py-2 px-0">
                            <h5 class="mb-0">
                                {{ $taskList->list_items }}
                            </h5>
                            <div class="action d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="material-symbols-rounded">more_horiz</i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"
                                                href="{{ route('user.detailList', ['idProject' => $project->id, 'idTaskList' => $taskList->id]) }}">Detail</a>
                                        </li>
                                        @if (auth()->id() == $project->user_id ||
                                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('user.tasklist.viewEdit', ['idProject' => $project->id, 'idTaskList' => $taskList->id]) }}">Edit</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    class="dropdown-item"
                                                    onclick="event.preventDefault();
                                                            document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                    Hapus
                                                </a>
                                                <form id="delete-task-{{ $taskList->id }}"
                                                    action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    method="POST" style="display: none;">
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
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded">calendar_today</i>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d F Y') }}
                                </li>
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}">flag</i>{{ $taskList->priority }}
                                </li>
                            </ul>
                        </div>
                    </li>
                @empty
                    <p class="m-1 text-center">No tasks</p>
                @endforelse
            </ul>
        </div>

        <div class="col-md-4 my-2">
            <div class="card bg-warning">
                <div class="card-body d-flex justify-content-between align-items-center m-3 p-0">
                    <h4 class="mb-0 text-white">In Progress</h4>
                    <i class="material-symbols-rounded text-white">progress_activity</i>
                </div>
            </div>
            <ul id="exampleMiddle" class="list-group list-group-flush list-group-item-secondary">
                @forelse ($project->taskLists->where('status', 'in_progress') as $taskList)
                    <li class="card list-group-item list-items rounded my-2 border border-2 bg-white border-status shadow"
                        data-id="{{ $taskList->id }}">
                        <div
                            class="card-header bg-transparent border-bottom border-status d-flex justify-content-between py-2 px-0">
                            <h5 class="mb-0">
                                {{ $taskList->list_items }}
                            </h5>
                            <div class="action d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="material-symbols-rounded">more_horiz</i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"
                                                href="{{ route('user.detailList', ['idProject' => $project->id, 'idTaskList' => $taskList->id]) }}">Detail</a>
                                        </li>
                                        @if (auth()->id() == $project->user_id ||
                                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('user.tasklist.viewEdit', ['idProject' => $project->id, 'idTaskList' => $taskList->id]) }}">Edit</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    class="dropdown-item"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                    Hapus
                                                </a>
                                                <form id="delete-task-{{ $taskList->id }}"
                                                    action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    method="POST" style="display: none;">
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
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded">calendar_today</i>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d F Y') }}
                                </li>
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}">flag</i>{{ $taskList->priority }}
                                </li>
                            </ul>
                        </div>
                    </li>
                @empty
                    <p class="m-1 text-center">No tasks</p>
                @endforelse
            </ul>
        </div>

        <div class="col-md-4 my-2">

            <div class="card bg-success">
                <div class="card-body d-flex justify-content-between align-items-center m-3 p-0">
                    <h4 class="mb-0 text-white">Completed</h4>
                    <i class="material-symbols-rounded text-white">task_alt</i>
                </div>
            </div>
            <ul id="exampleRight" class="list-group list-group-flush list-group-item-secondary">
                @forelse ($project->taskLists->where('status', 'completed') as $taskList)
                    <li class="card list-group-item list-items rounded my-2 border border-2 bg-white border-status shadow"
                        data-id="{{ $taskList->id }}">
                        <div
                            class="card-header bg-transparent border-bottom border-status d-flex justify-content-between py-2 px-0">
                            <h5 class="mb-0">
                                {{ $taskList->list_items }}
                            </h5>
                            <div class="action d-flex align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="material-symbols-rounded">more_horiz</i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item"
                                                href="{{ route('user.detailList', ['idProject' => $project->id, 'idTaskList' => $taskList->id]) }}">Detail</a>
                                        </li>
                                        @if (auth()->id() == $project->user_id ||
                                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                            <li>
                                                <a href="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    class="dropdown-item"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('delete-task-{{ $taskList->id }}').submit();">
                                                    Hapus
                                                </a>
                                                <form id="delete-task-{{ $taskList->id }}"
                                                    action="{{ route('user.tasklist.destroy', $taskList->id) }}"
                                                    method="POST" style="display: none;">
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
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded">calendar_today</i>{{ \Carbon\Carbon::parse($taskList->end_date)->format('d F Y') }}
                                </li>
                                <li class="list-group-item px-0 py-1 border-0"><i
                                        class="material-symbols-rounded text-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}">flag</i>{{ $taskList->priority }}
                                </li>
                            </ul>
                        </div>
                    </li>
                @empty
                    <p class="m-1 text-center">No tasks</p>
                @endforelse
            </ul>
        </div>
        {{-- @include('user.modal.note-project') --}}
    </div>
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
            var permissionType = "{{ session('permission_type', 'view') }}";
            var message = "URL " + permissionType + " disalin: " + copyText.value;

            navigator.clipboard.writeText(copyText.value)
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
