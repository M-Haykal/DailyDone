@extends('user.layouts.app')

@section('title', $project->name)

@section('content')
    <div class="container">
        <div class="page-header min-height-300 border-radius-xl mt-2"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
            <span class="mask  bg-gradient-dark  opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <h1 class="mb-0 text-white">{{ $project->name }}</h1>
                        <p class="text-white">{{ $project->description }}</p>
                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-primary" href="#" role="button" data-bs-toggle="modal"
                                data-bs-target="#shareProject"><i class="material-symbols-rounded">share</i>Share</a>
                            @if (auth()->id() == $project->user_id ||
                                    $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                                <a href="{{ route('user.tasklist.index', ['project_id' => $project->id]) }}"
                                    class="btn btn-success text-decoration-none">
                                    <i class="material-symbols-rounded">add</i>
                                    Add Task
                                </a>
                            @endif
                        </div>
                        <div class="avatar-group mt-2">
                            <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" title="Project Owner: {{ $project->owner->name }}">
                                <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                    alt="{{ $project->owner->name }}">
                            </a>
                            @foreach ($project->sharedUsers as $user)
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                    <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                        alt="user{{ $loop->index + 2 }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.modal.share-project')

        <div class="row my-3">
            <div class="col-md-4 my-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center m-3 p-0">
                        <h4>To Do</h4>
                        @if (auth()->id() == $project->user_id ||
                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                            <a href="javascript:void(0);" id="delete-selected">
                                <i class="material-symbols-rounded">delete</i>
                            </a>
                        @endif
                    </div>
                    <ul id="exampleLeft" class="list-group list-group-flush list-group-item-secondary">
                        @forelse ($project->taskLists->where('status', 'pending') as $taskList)
                            <li class="list-group-item list-items d-flex justify-content-between align-items-center m-1 rounded"
                                data-id="{{ $taskList->id }}">
                                {{ $taskList->list_items }}
                                <div class="action d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input task-checkbox" type="checkbox"
                                            value="{{ $taskList->id }}" id="flexCheckDefault">
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="material-symbols-rounded text-white">more_vert</i>
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
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item m-1 rounded">No tasks</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-md-4 my-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center m-3 p-0">
                        <h4>In Progress</h4>
                        @if (auth()->id() == $project->user_id ||
                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                            <a href="javascript:void(0);" id="delete-selected">
                                <i class="material-symbols-rounded">delete</i>
                            </a>
                        @endif
                    </div>
                    <ul id="exampleMiddle" class="list-group list-group-flush list-group-item-secondary">
                        @forelse ($project->taskLists->where('status', 'in_progress') as $taskList)
                            <li class="list-group-item list-items d-flex justify-content-between align-items-center m-1 rounded"
                                data-id="{{ $taskList->id }}">
                                {{ $taskList->list_items }}
                                <div class="action d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input task-checkbox" type="checkbox"
                                            value="{{ $taskList->id }}" id="flexCheckDefault">
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="material-symbols-rounded text-white">more_vert</i>
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
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item m-1 rounded">No tasks</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="col-md-4 my-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center m-3 p-0">
                        <h4>Completed</h4>
                        @if (auth()->id() == $project->user_id ||
                                $project->sharedUsers()->where('user_id', auth()->id())->where('permissions', 'edit')->exists())
                            <a href="javascript:void(0);" id="delete-selected">
                                <i class="material-symbols-rounded">delete</i>
                            </a>
                        @endif
                    </div>
                    <ul id="exampleRight" class="list-group list-group-flush list-group-item-secondary">
                        @forelse ($project->taskLists->where('status', 'completed') as $taskList)
                            <li class="list-group-item list-items d-flex justify-content-between align-items-center m-1 rounded"
                                data-id="{{ $taskList->id }}">
                                {{ $taskList->list_items }}
                                <div class="action d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input task-checkbox" type="checkbox"
                                            value="{{ $taskList->id }}" id="flexCheckDefault">
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link mb-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="material-symbols-rounded text-white">more_vert</i>
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
                                            @endif

                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#commentTasklist">
                                                    Comment
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item m-1 rounded">No tasks</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            @include('user.modal.comment-tasklist')
        </div>
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
                    pull: true,
                    put: true
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
                taskItem.classList.remove("bg-danger", "bg-warning", "bg-success");

                if (status === "pending") {
                    taskItem.classList.add("bg-danger", "text-white");
                } else if (status === "in_progress") {
                    taskItem.classList.add("bg-warning", "text-white");
                } else if (status === "completed") {
                    taskItem.classList.add("bg-success", "text-white");
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

            document.querySelectorAll(".list-items").forEach(item => {
                let status = item.closest("ul").id === "exampleLeft" ? "pending" :
                    item.closest("ul").id === "exampleMiddle" ? "in_progress" : "completed";
                updateTaskColor(item, status);
            });

            initializeSortable("exampleLeft", "pending");
            initializeSortable("exampleMiddle", "in_progress");
            initializeSortable("exampleRight", "completed");
        });

        document.querySelectorAll("#delete-selected").forEach(button => {
            button.addEventListener("click", function() {
                let selectedTasks = [];
                let parentCard = this.closest(".card");

                parentCard.querySelectorAll(".task-checkbox:checked").forEach((checkbox) => {
                    selectedTasks.push(checkbox.value);
                });

                if (selectedTasks.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Pilih tugas yang ingin dihapus!'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    fetch("{{ route('taskLists.bulkDelete') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                            body: JSON.stringify({
                                task_ids: selectedTasks
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                selectedTasks.forEach((id) => {
                                    let listItem = parentCard.querySelector(
                                        `[data-id='${id}']`);
                                    if (listItem) listItem.remove();
                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Tugas berhasil dihapus!',
                                    'success'
                                );
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Gagal menghapus tugas: ' + (data.message ||
                                        'Terjadi kesalahan tidak diketahui')
                                });
                                console.error("Error:", data);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan tidak diketahui!'
                            });
                        });
                });
            });
        });
    </script>
@endsection
