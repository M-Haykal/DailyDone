<div class="modal" tabindex="-1" id="editBackgroundImage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Background Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.project.edit', ['id' => $project->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div id="drop-area" class="border border-primary rounded-3 p-3 text-center bg-light"
                            style="cursor: pointer;" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                            <label for="image_project" class="form-label">Drag & Drop or Click to Upload</label>
                            <input class="form-control d-none" type="file" id="background_project"
                                name="background_project" accept="image/*" required onchange="previewImage(event)">
                            <div id="preview-container" class="mt-2"></div>
                        </div>
                    </div>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
