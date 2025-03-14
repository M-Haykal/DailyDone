@extends('user.layouts.app')

@section('title', 'Deadline')

@section('content')
    <div>
        <h1>Halaman Deadline</h1>
    </div>
    <div class="row">
        <div class="col-xl-6 my-2">
            <div class="card p-3">
                <h5 class="card-title mb-4">Task List Deadlines</h5>
                <div id="calendar-task"></div>
            </div>
        </div>
        <div class="col-xl-12 my-2">
            <div class="card p-3">
                <h5 class="card-title mb-4">Project Deadlines</h5>
                <div id="calendar-project"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var taskData = @json($tasks);

            var calendarEl = document.getElementById('calendar-task');

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
        document.addEventListener('DOMContentLoaded', function() {
            var projectData = @json($project);

            var calendarEl = document.getElementById('calendar-project');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',

                events: projectData.map(function(project) {
                    return {
                        id: project.id,
                        title: `${project.name}`,
                        start: project.start_date,
                        end: project.end_date,
                    };
                }),
            });

            calendar.render();
        })
    </script>
@endsection
