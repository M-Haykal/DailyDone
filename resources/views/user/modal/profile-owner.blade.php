<!-- Modal Profile Owner -->
<div class="modal fade" id="ownerProfileModal{{ $project->owner->id }}" tabindex="-1"
    aria-labelledby="ownerProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ownerProfileModalLabel">Project Owner Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="avatar avatar-xxl mb-3">
                    <img src="{{ $project->owner->image_profile ? url('storage/images/' . $project->owner->image_profile) : Avatar::create($project->owner->name)->toBase64() }}"
                        class="rounded-circle" alt="{{ $project->owner->name }}">
                </div>
                <h4>{{ $project->owner->name }}</h4>
                <p class="text-muted">{{ $project->owner->email }}</p>

                {{-- @if ($project->owner->bio)
                    <p>{{ $project->owner->bio }}</p>
                @endif --}}

                <div class="d-flex justify-content-center">
                    <a href="{{ route('user', ['id' => $project->owner->id]) }}" class="btn btn-primary">
                        <i class="fas fa-comment-dots me-2"></i> Chat
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
