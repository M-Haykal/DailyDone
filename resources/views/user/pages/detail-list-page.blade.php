@extends('user.layouts.app')

@section('title', 'Detail Task Page')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            <!-- Task Details Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <a href="{{ url()->previous() }}" class="text-decoration-none text-muted">
                                <i class="fas fa-arrow-left fs-4"></i>
                            </a>
                            <h2 class="card-title fw-bold text-dark mb-0">{{ $taskList->list_items }}</h2>
                        </div>
                        <p class="card-text text-muted mb-4">{!! htmlspecialchars_decode($taskList->detail_list) !!}</p>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <strong class="text-dark">Status:</strong>
                                <span
                                    class="badge rounded-pill text-white fw-semibold
                                        {{ $taskList->status === 'pending' ? 'bg-danger' : ($taskList->status === 'in_progress' ? 'bg-warning' : 'bg-success') }}">
                                    {{ $taskList->status }}
                                </span>
                            </div>
                            <div class="col-6">
                                <strong class="text-dark">Priority:</strong>
                                <span
                                    class="badge rounded-pill text-white fw-semibold
                                        {{ $taskList->priority === 'high' ? 'bg-danger' : ($taskList->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                                    {{ $taskList->priority }}
                                </span>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <strong class="text-dark">Tag:</strong>
                                <div class="d-inline">
                                    @foreach (explode(',', $taskList->tag) as $userId)
                                        @if ($user = $users->find($userId))
                                            <span class="badge bg-secondary text-white me-1">{{ $user->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-6">
                                <strong class="text-dark">Note:</strong>
                                <span class="text-muted">{{ $taskList->note ?? 'No note' }}</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <strong class="text-dark">Start Date:</strong>
                                <span class="text-muted">{{ $taskList->start_date ?? 'Not set' }}</span>
                            </div>
                            <div class="col-6">
                                <strong class="text-dark">End Date:</strong>
                                <span class="text-muted">{{ $taskList->end_date ?? 'Not set' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3"
                    style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="card-title fw-bold text-dark mb-0">Comments</h2>
                        </div>
                        <ul class="list-group list-group-flush" id="comment-list">
                        </ul>
                        <div id="reply-container" class="mt-3 d-none">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong class="text-dark">Replying to <span id="replying-to"
                                        class="text-primary"></span></strong>
                                <button type="button" class="btn btn-sm btn-danger" id="cancel-reply">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group mt-3">
                            <input type="text" class="form-control" id="comment-content"
                                placeholder="Enter your comment...">
                            <button type="button" class="btn btn-success" id="btn-comment">Comment</button>
                        </div>
                        <input type="hidden" id="reply-comment-id">
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
                                repliesHtml += '<ul class="list-group list-group-flush mt-2">';
                                comment.replies.forEach(reply => {
                                    repliesHtml += `
                                    <li class="list-group-item bg-light border-0 ps-4">
                                        <strong class="text-dark">${reply.user.name}:</strong> <span class="text-muted">${reply.content}</span>
                                    </li>`;
                                });
                                repliesHtml += '</ul>';
                            }

                            commentList.append(`
                            <li class="list-group-item bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-dark">${comment.user.name}:</strong> <span class="text-muted">${comment.content}</span>
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
