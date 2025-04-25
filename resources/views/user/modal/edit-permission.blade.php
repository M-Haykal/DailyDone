@foreach ($project->sharedProjects as $shared)
    <div class="modal fade" id="editPermission{{ $shared->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage {{ $shared->user?->name ?? $shared->email }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs nav-fill" id="userTab{{ $shared->id }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab-{{ $shared->id }}" data-bs-toggle="tab"
                                data-bs-target="#profile-{{ $shared->id }}" type="button"
                                role="tab">Profile</button>
                        </li>
                        @if (auth()->id() == $project->user_id || auth()->user()->can('edit', $project))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="permission-tab-{{ $shared->id }}" data-bs-toggle="tab"
                                    data-bs-target="#permission-{{ $shared->id }}" type="button"
                                    role="tab">Permissions</button>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content pt-3" id="userTabContent{{ $shared->id }}">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-{{ $shared->id }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ $shared->user ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user?->name ?? ($shared->email ?? 'Unknown'))->toBase64() }}"
                                        alt="{{ $shared->user?->name ?? ($shared->email ?? 'Unknown') }}"
                                        class="img-fluid rounded-circle mb-3" style="width: 120px;">
                                    <h5>{{ $shared->user?->name ?? $shared->email }}</h5>
                                    <p class="text-muted">{{ $shared->user?->email ?? '-' }}</p>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control"
                                            value="{{ $shared->user?->role ?? '-' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Joined</label>
                                        <input type="text" class="form-control"
                                            value="{{ $shared->user?->created_at?->format('d M Y') ?? '-' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Project Permission</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($shared->permissions) ?? '-' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permission Tab (only visible to owner/editors) -->
                        @if (auth()->id() == $project->user_id || auth()->user()->can('edit', $project))
                            <div class="tab-pane fade" id="permission-{{ $shared->id }}" role="tabpanel">
                                <form
                                    action="{{ route('user.project.editPermission', ['project' => $project->id, 'sharedProject' => $shared->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control"
                                            value="{{ $shared->user ? $shared->user->email : $shared->email }}"
                                            readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Permission Level</label>
                                        <select name="permissions" class="form-select">
                                            <option value="view"
                                                {{ $shared->permissions == 'view' ? 'selected' : '' }}>Can View
                                            </option>
                                            <option value="edit"
                                                {{ $shared->permissions == 'edit' ? 'selected' : '' }}>Can Edit
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDeleteAccess('{{ $shared->id }}')">
                                            <i class="fas fa-trash me-1"></i> Remove Access
                                        </button>

                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="deleteAccessForm{{ $shared->id }}"
        action="{{ route('user.project.deleteAccess', ['project' => $project->id, 'sharedProject' => $shared->id]) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form>
@endforeach
