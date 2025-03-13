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
        <div class="col-xl-8 my-2">
            {{-- <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Project List</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($projects as $project)
                            <li class="list-group-item">
                                @if ($project->user_id == auth()->id() ||
    $project->sharedUsers()->where('user_id', auth()->id())->exists())
                                    <a class="nav-link text-dark d-flex justify-content-between align-items-center"
                                        href="{{ route('projects.show', $project->id) }}">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $project->name }}</div>
                                            <span>Deadline:
                                                {{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}</span>
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
            </div> --}}

            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h5 class="card-title">Projects</h5>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md"
                                            href="{{ route('user.dashboard', ['sort' => 'az']) }}">A - Z</a></li>
                                    <li><a class="dropdown-item border-radius-md"
                                            href="{{ route('user.dashboard', ['sort' => 'newest']) }}">New Projects</a></li>
                                    <li><a class="dropdown-item border-radius-md"
                                            href="{{ route('user.dashboard', ['sort' => 'deadline']) }}">Closest
                                            Deadline</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Projects
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Members
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Deadline</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Detail Task</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    @if (
                                        $project->user_id == auth()->id() ||
                                            $project->sharedUsers()->where('user_id', auth()->id())->exists())
                                        <tr>
                                            <a href="{{ route('projects.show', $project->id) }}">
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $project->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="avatar-group mt-2">
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Project Owner: {{ $project->owner->name }}">
                                                            <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                                alt="{{ $project->owner->name }}">
                                                        </a>
                                                        @foreach ($project->sharedUsers as $user)
                                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title="{{ $user->name }} ({{ $user->pivot->permissions }})">
                                                                <img src="{{ $user->image_profile ? url('storage/images/' . $user->image_profile) : Avatar::create($user->name)->toBase64() }}"
                                                                    alt="user{{ $loop->index + 2 }}">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-xs font-weight-bold">{{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}</span>
                                                </td>
                                                <td
                                                    class="align-middle mt-3">
                                                    <div class="d-flex justify-content-center">
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
                                                </td>
                                            </a>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination my-3 justify-content-center">
                            {{ $projects->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 my-2">
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
        <div class="col-xl-6 my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Task Status</h5>
                    <canvas id="myChart"></canvas>
                </div>
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
                        title: `${task.title} - ${task.project}`,
                        start: task.start,
                        end: task.end,
                    };
                }),
            });

            calendar.render();
        });
        var data = {!! json_encode($formattedData) !!};

        var months = Object.keys(data);
        var statuses = ["pending", "in_progress", "completed"];
        var colors = {
            "pending": "red",
            "in_progress": "yellow",
            "completed": "green"
        };

        var datasets = statuses.map(status => ({
            label: status,
            data: months.map(month => data[month][status] || 0),
            backgroundColor: colors[status],
            borderColor: colors[status],
            borderWidth: 1
        }));

        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
