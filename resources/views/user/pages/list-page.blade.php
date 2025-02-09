@extends('user.layouts.app')

@section('title', $project->name)

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">{{ $project->name }}</h1>
            <div class="d-grid gap-2 d-md-block">
                <a class="btn btn-primary" href="#" role="button"><i class="material-symbols-rounded">share</i>Share</a>
                <a href="{{ route('user.tasklist.index', ['project_id' => $project->id]) }}"
                    class="btn btn-success text-decoration-none">
                    <i class="material-symbols-rounded">add</i>
                    Add Task
                </a>
            </div>
        </div>
        <h2 class="text-muted">{{ $project->description }}</h2>

        <div class="row my-5">
            <!-- List Kiri (Sumber) -->
            <div class="col-md-4">
                <h4>Belum Dikerjakan</h4>
                <ul id="exampleLeft" class="list-group">
                    @forelse ($project->taskLists->where('status', 'pending') as $taskList)
                        <li class="list-group-item" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada tugas.</li>
                    @endforelse
                </ul>
            </div>

            <!-- List Tengah -->
            <div class="col-md-4">
                <h4>Sedang Dikerjakan</h4>
                <ul id="exampleMiddle" class="list-group">
                    @forelse ($project->taskLists->where('status', 'in_progress') as $taskList)
                        <li class="list-group-item" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada tugas.</li>
                    @endforelse
                </ul>
            </div>

            <!-- List Kanan -->
            <div class="col-md-4">
                <h4>Selesai Dikerjakan</h4>
                <ul id="exampleRight" class="list-group">
                    @forelse ($project->taskLists->where('status', 'completed') as $taskList)
                        <li class="list-group-item" data-id="{{ $taskList->id }}">{{ $taskList->list_items }}</li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada tugas.</li>
                    @endforelse
                </ul>
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
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateTaskStatus(taskId, status) {
                fetch(`user/tasklist/${taskId}/update-status`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content")
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    }).then(response => response.json())
                    .then(data => console.log(data))
                    .catch(error => console.error("Error:", error));
            }

            function initializeSortable(containerId, status) {
                new Sortable(document.getElementById(containerId), {
                    group: "shared",
                    animation: 150,
                    onEnd: function(evt) {
                        let taskId = evt.item.getAttribute("data-id");
                        updateTaskStatus(taskId, status);
                    }
                });
            }

            initializeSortable("exampleLeft", "pending");
            initializeSortable("exampleMiddle", "in_progress");
            initializeSortable("exampleRight", "completed");
        });
    </script>
@endsection
