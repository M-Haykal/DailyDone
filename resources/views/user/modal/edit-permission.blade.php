@foreach ($project->sharedProjects as $shared)
    <div class="modal fade" id="editPermission{{ $shared->id }}" tabindex="-1"
        aria-labelledby="editPermissionLabel{{ $shared->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title" id="editPermissionLabel{{ $shared->id }}">Manage
                        {{ $shared->user?->name ?? $shared->email }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <ul class="nav nav-tabs nav-fill mb-4" id="userTab{{ $shared->id }}" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab-{{ $shared->id }}" data-bs-toggle="tab"
                                data-bs-target="#profile-{{ $shared->id }}" type="button" role="tab"
                                aria-controls="profile-{{ $shared->id }}" aria-selected="true">Profile</button>
                        </li>
                        @if (auth()->id() == $project->user_id || auth()->user()->can('edit', $project))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="permission-tab-{{ $shared->id }}" data-bs-toggle="tab"
                                    data-bs-target="#permission-{{ $shared->id }}" type="button" role="tab"
                                    aria-controls="permission-{{ $shared->id }}"
                                    aria-selected="false">Permissions</button>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="userTabContent{{ $shared->id }}">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-{{ $shared->id }}" role="tabpanel"
                            aria-labelledby="profile-tab-{{ $shared->id }}">
                            <div class="row g-4">
                                <div class="col-md-4 text-center">
                                    <img src="{{ optional($shared->user)->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->email ?? 'Unknown')->toBase64() }}"
                                        alt="{{ $shared->user?->name ?? $shared->email ?? 'Unknown' }}"
                                        class="img-fluid rounded-circle mb-3 shadow-sm" style="width: 120px;">
                                    <h5 class="fw-bold">{{ $shared->user?->name ?? $shared->email ?? 'Unknown' }}</h5>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $shared->user?->email ?? '-' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Joined</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $shared->user?->created_at?->format('d M Y') ?? '-' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Project Permission</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ ucfirst($shared->permissions) ?? '-' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permission Tab (only visible to owner/editors) -->
                        @if (auth()->id() == $project->user_id || auth()->user()->can('edit', $project))
                            <div class="tab-pane fade" id="permission-{{ $shared->id }}" role="tabpanel"
                                aria-labelledby="permission-tab-{{ $shared->id }}">
                                <form
                                    action="{{ route('user.project.editPermission', ['project' => $project->id, 'sharedProject' => $shared->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <input type="email" class="form-control bg-light"
                                            value="{{ $shared->user ? $shared->user->email : $shared->email }}"
                                            readonly>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Change Permission</label>
                                        <select name="permissions" class="form-select">
                                            <option value="view"
                                                {{ $shared->permissions == 'view' ? 'selected' : '' }}>Can View
                                            </option>
                                            <option value="edit"
                                                {{ $shared->permissions == 'edit' ? 'selected' : '' }}>Can Edit
                                            </option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-outline-danger"
                                            onclick="confirmDeleteAccess('{{ $shared->id }}')">
                                            <i class="fas fa-trash me-1"></i> Remove Access
                                        </button>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-outline-secondary"
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
        method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endforeach
