@extends('user.layouts.app')

@section('title', $project->name)

@section('content')
    <div class="container mt-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
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
                    </div>
                </div>
            </div>
        </div>
        @include('user.modal.share-project')
        <div class="card mt-4">
            <div class="card-header">
                <h4>Users in this Project</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Project Owner:</strong> {{ $project->owner->name }} (Owner)
                    </li>
                    @foreach ($project->sharedUsers as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $user->name }} ({{ $user->pivot->permissions }})
                            {{-- @if (auth()->id() == $project->user_id)
                                <form
                                    action="{{ route('user.remove-user', ['project_id' => $project->id, 'user_id' => $user->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            @endif --}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row my-5">
            <!-- List Kiri (Sumber) -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Belum Dikerjakan</h4>
                    </div>
                    <ul id="exampleLeft" class="list-group list-group-flush">
                        @forelse ($project->taskLists->where('status', 'pending') as $taskList)
                            <li class="list-group-item list-items" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                        @empty
                            <li class="list-group-item text-muted list-items">Belum ada tugas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- List Tengah -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Sedang Dikerjakan</h4>
                    </div>
                    <ul id="exampleMiddle" class="list-group list-group-flush">
                        @forelse ($project->taskLists->where('status', 'in_progress') as $taskList)
                            <li class="list-group-item list-items" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                        @empty
                            <li class="list-group-item text-muted list-items">Belum ada tugas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- List Kanan -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Selesai Dikerjakan</h4>
                    </div>
                    <ul id="exampleRight" class="list-group list-group-flush">
                        @forelse ($project->taskLists->where('status', 'completed') as $taskList)
                            <li class="list-group-item list-items" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                        @empty
                            <li class="list-group-item text-muted list-items">Belum ada tugas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

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

@endsection


@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateTaskStatus(taskId, status) {
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
                    taskItem.classList.add("bg-warning", "text-dark");
                } else if (status === "completed") {
                    taskItem.classList.add("bg-success", "text-white");
                }
            }

            function initializeSortable(containerId, status) {
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
    </script>
@endsection
