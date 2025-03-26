@extends('user.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="my-3">
            <h3 class="mb-0 h4 font-weight-bolder">
                Halo
            </h3>
            <p>
                {{ auth()->user()->name }}
            </p>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card bg-gradient-info shadow-info">
                <div class="card-header p-2 ps-3 bg-transparent border-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white text-sm mb-0 text-capitalize">Total Projects</p>
                            <h4 class="text-white mb-0">{{ $projectCount }}</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10 text-white">folder</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card bg-gradient-success shadow-success">
                <div class="card-header p-2 ps-3 bg-transparent border-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white text-sm mb-0 text-capitalize">Total Tasks</p>
                            <h4 class="text-white mb-0">{{ $taskListCount }}</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10 text-white">task</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card bg-gradient-secondary shadow-dark">
                <div class="card-header p-2 ps-3 bg-transparent border-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white text-sm mb-0 text-capitalize">Total Archive</p>
                            <h4 class="text-white mb-0">{{ $projectEnded }}</h4>
                        </div>
                        <div
                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                            <i class="material-symbols-rounded opacity-10 text-white">archive</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 my-2">
            <div class="card mb-3">
                <div class="card-body p-3">
                    <h5 class="mb-0 ">Task Status</h5>
                    <p class="text-sm ">Last Campaign Performance</p>
                    <div class="chart">
                        <canvas id="chart-pie-task-status" class="chart-canvas" height="170" width="309"
                            style="display: block; box-sizing: border-box; height: 170px; width: 309px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 my-2">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Projects</h5>
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
                                                <td class="align-middle mt-3">
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
    </div>
@endsection

@section('script')
    <script>
        const ctx = document.getElementById('chart-pie-task-status').getContext('2d');
        const taskStatus = @json($taskStatus);
        const labels = Object.keys(taskStatus);
        const data = Object.values(taskStatus).map(status => status.length);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    label: 'Task Status',
                    data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

@endsection
