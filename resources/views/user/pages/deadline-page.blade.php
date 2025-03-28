@extends('user.layouts.app')

@section('title', 'Deadline')

@section('content')
    <div class="row">
        <div class="col-xl-12 my-2">
            <div class="card p-3">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var taskData = @json($tasks);
            var projectData = @json($project);

            var calendarEl = document.getElementById('calendar');

            var events = [];

            events = events.concat(taskData.map(function(task) {
                return {
                    id: task.id,
                    title: `${task.title} - ${task.project}`,
                    start: task.start,
                    end: task.end,
                    color: '#007bff',
                };
            }));

            events = events.concat(projectData.map(function(project) {
                return {
                    id: project.id,
                    title: project.name,
                    start: project.start_date,
                    end: project.end_date,
                    color: '#28a745',
                    url: "{{ route('projects.show', ':id') }}".replace(':id', project.id),
                    extendedProps: {
                        type: 'project'
                    }
                };
            }));

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate

                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                }
            });

            calendar.render();
        });
    </script>
@endsection
