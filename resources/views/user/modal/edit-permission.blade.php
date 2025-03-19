<div class="modal" tabindex="-1" id="editPermission{{ $sharedProject->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.project.editPermission', ['id' => $project->id, 'sharedProjectId' => $sharedProject->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $sharedProject->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Izin:</label>
                        <select name="permissions" class="form-control">
                            <option value="view" {{ $sharedProject->permissions == 'view' ? 'selected' : '' }}>Can View</option>
                            <option value="edit" {{ $sharedProject->permissions == 'edit' ? 'selected' : '' }}>Can Edit</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
