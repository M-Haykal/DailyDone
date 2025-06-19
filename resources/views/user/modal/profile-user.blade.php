@foreach ($project->sharedProjects as $shared)
    @if ($shared->user)
        <div class="modal fade" id="profileModal{{ $shared->user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="{{ $shared->user->image_profile ? url('storage/images/' . $shared->user->image_profile) : Avatar::create($shared->user->name)->toBase64() }}"
                            alt="{{ $shared->user->name }}" class="img-fluid rounded-circle mb-3" style="width: 120px;">
                        <div class="mt-3">
                            <h5>{{ $shared->user->name }}</h5>
                            <p><strong>Email:</strong> {{ $shared->user->email }}</p>
                            <p><strong>Joined:</strong> {{ $shared->user->created_at->format('d M Y') }}</p>
                            <p><strong>Project Permission:</strong> {{ $shared->permissions }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
