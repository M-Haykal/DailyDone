<div class="modal" tabindex="-1" id="shareProject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/projects/' . $project->id . '/share') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email Pengguna:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Izin:</label>
                        <select name="permissions" class="form-control">
                            <option value="view">Hanya Lihat</option>
                            <option value="edit">Dapat Edit</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Bagikan</button>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
