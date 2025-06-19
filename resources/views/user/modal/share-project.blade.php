<div class="modal fade" id="shareProject" tabindex="-1" aria-labelledby="shareProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="shareProjectLabel">Share Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <ul class="nav nav-tabs nav-fill mb-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="email-tab" data-bs-toggle="tab" href="#share-email"
                            role="tab" aria-controls="share-email" aria-selected="true">Share by Email</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="link-tab" data-bs-toggle="tab" href="#share-link" role="tab"
                            aria-controls="share-link" aria-selected="false">Share by Link</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="share-email" role="tabpanel" aria-labelledby="email-tab">
                        <form action="{{ url('/projects/' . $project->id . '/share') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="emailDestination" class="form-label fw-bold">Email Destination</label>
                                <input type="email" name="email" class="form-control" id="emailDestination"
                                    placeholder="Enter email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailPermissions" class="form-label fw-bold">Permissions</label>
                                <select name="permissions" id="emailPermissions" class="form-select">
                                    <option value="edit">Can Edit</option>
                                    <option value="view">Can View</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Share</button>
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        </form>
                    </div>
                    <div class="tab-pane fade" id="share-link" role="tabpanel" aria-labelledby="link-tab">
                        <form action="{{ route('projects.shareBySlug', ['slug' => $project->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="linkPermissions" class="form-label fw-bold">Permissions</label>
                                <select name="permissions" id="linkPermissions" class="form-select" required>
                                    <option value="edit">Can Edit</option>
                                    <option value="view">Can View</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Generate URL</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
