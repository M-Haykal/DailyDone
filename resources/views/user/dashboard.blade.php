@extends('user.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="row overflow-x-hidden">
        <div class="my-3">
            <h3 class="mb-0 h4 font-weight-bolder me-auto">Dashboard</h3>
            <p class="mb-0 ms-auto text-secondary">
                Plan, Do, Done.
            </p>
        </div>
        <div class="col-xl-6 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project List</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($projects as $project)
                            <li class="list-group-item">
                                @if (
                                    $project->user_id == auth()->id() ||
                                        $project->sharedUsers()->where('user_id', auth()->id())->exists())
                                    <a class="nav-link text-dark d-flex justify-content-between align-items-center"
                                        href="{{ route('projects.show', $project->id) }}">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $project->name }}</div>
                                            {{ Str::limit($project->description, 20) }}
                                        </div>
                                        <div class="d-flex">
                                            @php
                                                $statuses = [
                                                    'pending' => 'danger',
                                                    'in_progress' => 'warning',
                                                    'completed' => 'success',
                                                ];
                                            @endphp
                                            @foreach ($statuses as $status => $badgeClass)
                                                <span class="badge text-bg-{{ $badgeClass }} me-2"
                                                    title="{{ ucfirst(str_replace('_', ' ', $status)) }}">
                                                    {{ $project->taskLists->where('status', $status)->count() }}</span>
                                            @endforeach
                                        </div>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                        <div class="pagination my-3 justify-content-center">
                            {{ $projects->links('pagination::bootstrap-4') }}
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Quote of the Day</h5>
                    <blockquote class="blockquote text-center">
                        <p class="font-italic text-primary">{{ $quote['quote'] }}</p>
                        <footer class="blockquote-footer mt-2">{{ $quote['author'] }}</footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-xl-6 my-2">
            <div class="card p-3">
                <h5 class="card-title mb-4">Task List with Deadlines</h5>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var taskData = @json($tasks);

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: taskData.map(function(task) {
                    return {
                        id: task.id,
                        title: task.title,
                        start: task.start,
                        end: task.end,
                        description: task.body
                    };
                }),
            });

            calendar.render();
        });
    </script>
@endsection
