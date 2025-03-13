@extends('user.layouts.app')

@section('title', 'Detail List')

@section('content')
    <div class="d-flex align-items-center my-3">
        <a href="{{ url()->previous() }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Detail Task List</h3>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $taskList->list_items }}</h5>
                    <p class="card-text">{!! htmlspecialchars_decode($taskList->detail_list) !!}</p>
                    <div class="row">
                        <div class="col-6">
                            <strong>Status:</strong>
                            <span
                                class="badge rounded-pill bg-{{ $taskList->status === 'pending' ? 'danger' : ($taskList->status === 'in_progress' ? 'warning' : 'success') }}">{{ $taskList->status }}</span>
                        </div>
                        <div class="col-6">
                            <strong>Priority:</strong>
                            <span
                                class="badge rounded-pill bg-{{ $taskList->priority === 'high' ? 'danger' : ($taskList->priority === 'medium' ? 'warning' : 'success') }}">{{ $taskList->priority }}</span>
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Comments</h5>
                    </div>
                    <ul class="list-group list-group-flush" id="comment-list">
                    </ul>
                    <input type="hidden" id="reply-comment-id">
                    <div id="reply-container" class="mt-3 d-none">
                        <strong>Replying to <span id="replying-to"></span></strong>
                        <button type="button" class="btn btn-sm btn-danger" id="cancel-reply"><i
                                class="material-symbols-rounded">close</i></button>
                    </div>
                    <div class="input-group input-group-outline mt-3">
                        <input type="text" class="form-control" id="comment-content" placeholder="Enter text here">
                        <button type="button" class="btn btn-primary mb-0" id="btn-comment">Comment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            loadComments();

            function loadComments() {
                $.ajax({
                    url: "{{ route('user.comments.index') }}",
                    type: "GET",
                    data: {
                        task_list_id: "{{ $taskList->id }}"
                    },
                    success: function(response) {
                        let commentList = $("#comment-list");
                        commentList.empty();

                        response.forEach(comment => {
                            let repliesHtml = "";
                            if (comment.replies.length > 0) {
                                repliesHtml += '<ul class="list-group mt-2">';
                                comment.replies.forEach(reply => {
                                    repliesHtml += `
                                <li class="list-group-item border-0 ps-4">
                                    <strong>${reply.user.name}:</strong> ${reply.content}
                                </li>`;
                                });
                                repliesHtml += '</ul>';
                            }

                            commentList.append(`
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${comment.user.name}:</strong> ${comment.content}
                                </div>
                                <button class="btn btn-sm btn-link text-primary reply-btn" data-comment-id="${comment.id}" data-user="${comment.user.name}">Reply</button>
                            </div>
                            ${repliesHtml}
                        </li>
                    `);
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error('Failed to load comments: ' + thrownError);
                    }
                });
            }

            $("#btn-comment").click(function() {
                let content = $("#comment-content").val();
                let parentId = $("#reply-comment-id").val() || null;

                $.ajax({
                    url: "{{ route('user.comments.store') }}",
                    type: "POST",
                    data: JSON.stringify({
                        task_list_id: "{{ $taskList->id }}",
                        content: content,
                        parent_id: parentId
                    }),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        $("#comment-content").val("");
                        $("#reply-comment-id").val("");
                        $("#reply-container").addClass("d-none");
                        loadComments();
                    },
                    error: function(response) {
                        console.error('Failed to post comment:', response);
                    }
                });
            });

            $(document).on("click", ".reply-btn", function() {
                let commentId = $(this).data("comment-id");
                let userName = $(this).data("user");

                $("#reply-comment-id").val(commentId);
                $("#replying-to").text(userName);
                $("#reply-container").removeClass("d-none");
                $("#comment-content").focus();
            });

            $("#cancel-reply").click(function() {
                $("#reply-comment-id").val("");
                $("#reply-container").addClass("d-none");
            });
        });
    </script>
@endsection
