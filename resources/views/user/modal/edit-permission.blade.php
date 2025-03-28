<!-- Modal untuk masing-masing shared project -->
@foreach ($project->sharedProjects as $shared)
    <div class="modal fade" id="editPermission{{ $shared->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Izin untuk {{ $shared->user?->name ?? $shared->email }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="{{ route('user.project.editPermission', ['project' => $project->id, 'sharedProject' => $shared->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $shared->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Izin</label>
                            <select name="permissions" class="form-select">
                                <option value="view" {{ $shared->permissions == 'view' ? 'selected' : '' }}>Can View
                                </option>
                                <option value="edit" {{ $shared->permissions == 'edit' ? 'selected' : '' }}>Can Edit
                                </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger"
                                onclick="confirmDeleteAccess('{{ $shared->id }}')">
                                <i class="fas fa-trash me-1"></i> Hapus Akses
                            </button>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Access Form (hidden) -->
    <form id="deleteAccessForm{{ $shared->id }}"
        action="{{ route('user.project.deleteAccess', ['project' => $project->id, 'sharedProject' => $shared->id]) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form>
@endforeach
