<div class="modal" tabindex="-1" id="shareProject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Project</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/projects/' . $project->id . '/share') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email Destination</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Izin:</label>
                        <select name="permissions" class="form-control">
                            <option value="edit">Can Edit</option>
                            <option value="view">Can View</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Share</button>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
