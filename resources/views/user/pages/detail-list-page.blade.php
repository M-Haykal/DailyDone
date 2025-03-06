@extends('user.layouts.app')

@section('title', 'Detail List')

@section('content')
    <div class="my-3 d-flex align-items-center">
        <a href="{{ url()->previous() }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Detail Task List</h3>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">{{ $taskList->list_items }}</h3>
                    <p class="card-text">{!! htmlspecialchars_decode($taskList->detail_list) !!}</p>
                    <div class="row">
                        <div class="col-6">
                            <strong>Status:</strong>
                            @switch($taskList->status)
                                @case('pending')
                                    <span class="badge rounded-pill bg-danger">{{ $taskList->status }}</span>
                                @break

                                @case('in_progress')
                                    <span class="badge rounded-pill bg-warning">{{ $taskList->status }}</span>
                                @break

                                @case('completed')
                                    <span class="badge rounded-pill bg-success">{{ $taskList->status }}</span>
                                @break
                            @endswitch
                        </div>
                        <div class="col-6">
                            <strong>Priority:</strong>
                            @switch($taskList->priority)
                                @case('high')
                                    <span class="badge rounded-pill bg-danger">{{ $taskList->priority }}</span>
                                @break

                                @case('medium')
                                    <span class="badge rounded-pill bg-warning">{{ $taskList->priority }}</span>
                                @break

                                @case('low')
                                    <span class="badge rounded-pill bg-success">{{ $taskList->priority }}</span>
                                @break
                            @endswitch
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <strong>Tag:</strong> {{ $taskList->tag }}
                        </div>
                        <div class="col-6">
                            <strong>Note:</strong> {{ $taskList->note }}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <strong>Start Date:</strong> {{ $taskList->start_date }}
                        </div>
                        <div class="col-6">
                            <strong>End Date:</strong> {{ $taskList->end_date }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card text-center">
                <div class="card-body overflow-auto">
                    <ul class="list-group list-group-flush" id="comment-list">
                    </ul>
                </div>
                <div class="card-footer border-top">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-9">
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" id="comment-content"
                                    placeholder="Enter text here">
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary mb-0" id="btn-comment">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('user.comments.index') }}",
                type: "GET",
                success: function(response) {
                    $.each(response, function(index, comment) {
                        $("#comment-list").append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>${comment.content}</span>
                                    <span>${comment.user.name}</span>
                                </li>`
                        );
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error('Failed to load comments: ' + thrownError);
                }
            });

            $("#btn-comment").click(function() {
                $.ajax({
                    url: "{{ route('user.comments.store') }}",
                    type: "POST",
                    data: JSON.stringify({
                        task_list_id: "{{ $taskList->id }}",
                        content: $("#comment-content").val()
                    }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        $("#comment-list").append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>${response.content}</span>
                    <span>${response.user.name}</span>
                </li>`
                        );
                        $("#comment-content").val("");
                    },
                    error: function(response) {
                        console.error('Failed to post comment:', response);
                    }
                });
            });

        });
    </script>
@endsection
