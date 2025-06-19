@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container p-2">
        <div class="main-header bg-gradient-primary p-4 rounded-3 mb-5 shadow-sm">
            <div>
                <h3 class="mb-0 h4 font-weight-bold">Hello, {{ auth()->user()->name }}</h3>
                <p class="text-sm mb-0">Welcome to your dashboard!</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-sm-3 col-6">
                <div class="card bg-gradient-info shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Total Projects</p>
                                <h4 class="mb-0">{{ $projectCount }}</h4>
                            </div>
                            <i class="fa-solid fa-folder fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="card bg-gradient-success shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Total Tasks</p>
                                <h4 class="mb-0">{{ $taskListCount }}</h4>
                            </div>
                            <i class="fa-solid fa-list-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="card bg-gradient-secondary shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Total Archive</p>
                                <h4 class="mb-0">{{ $projectEnded }}</h4>
                            </div>
                            <i class="fa-solid fa-box-archive fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="card bg-gradient-warning shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Total Notes</p>
                                <h4 class="mb-0">{{ $noteCount }}</h4>
                            </div>
                            <i class="fa-solid fa-note-sticky fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-5">
            <h5 class="mb-3 font-weight-bold">Projects Statistics</h5>
            <hr class="my-2">
            <div class="col-sm-4 col-12 py-2">
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <canvas id="chart-pie-task-status" height="170"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-12 py-2">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            Projects
                                        </th>
                                        <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                            Group
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            Deadline</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                            Detail Task</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        @if (
                                            $project->user_id == auth()->id() ||
                                                $project->sharedUsers()->where('user_id', auth()->id())->exists())
                                            <tr>
                                                <td>
                                                    <a href="{{ route('projects.show', $project->slug) }}"
                                                        class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $project->name }}</h6>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="avatar-stack mt-2">
                                                        @foreach ($project->sharedProjects as $shared)
                                                            @if ($shared->user)
                                                                <a href="javascript:;"
                                                                    class="avatar avatar-sm rounded-circle"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#profileModal{{ $shared->user->id }}"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ $shared->user->name }} ({{ $shared->permissions }})">
                                                                    <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                                                                        alt="{{ $shared->user->name }}">
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                        <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                            data-bs-toggle="tooltip"
                                                            title="Pemilik: {{ $project->owner->name }}">
                                                            <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                                                                alt="{{ $project->owner->name }}">
                                                        </a>
                                                        @include('user.modal.profile-user')
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-sm font-weight-bold">{{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}</span>
                                                </td>
                                                <td class="align-middle text-center">
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
                                                                aria-label="{{ ucfirst(str_replace('_', ' ', $status)) }}: {{ $project->taskLists->where('status', $status)->count() }}">
                                                                {{ $project->taskLists->where('status', $status)->count() }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination my-3 justify-content-center">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('chart-pie-task-status').getContext('2d');
        const taskStatus = @json($taskStatus);
        const labels = Object.keys(taskStatus).map(status => status.replace('_', ' ').toUpperCase());
        const data = Object.values(taskStatus).map(status => status.length);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    label: 'Status Tugas',
                    data,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                    borderColor: ['#ff6384', '#36a2eb', '#ffcd56'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12,
                                family: 'Poppins'
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        document.getElementById('projectSearch').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.table tbody tr').forEach(row => {
                const projectName = row.querySelector('td:first-child h6').textContent.toLowerCase();
                row.style.display = projectName.includes(search) ? '' : 'none';
            });
        });
    </script>
@endsection
