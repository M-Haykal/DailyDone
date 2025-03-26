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
                <ul class="nav nav-fill nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#share-email"
                            role="tab" aria-controls="share-email" aria-selected="true"> Share By Email </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#share-link" role="tab"
                            aria-controls="share-link" aria-selected="false"> Share By Link </a>
                    </li>
                </ul>
                <div class="tab-content pt-5" id="tab-content">
                    <div class="tab-pane active" id="share-email" role="tabpanel" aria-labelledby="fill-tab-0">
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
                    <div class="tab-pane" id="share-link" role="tabpanel" aria-labelledby="fill-tab-1">
                        <form action="{{ route('projects.shareBySlug', ['slug' => $project->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Pilih Izin</label>
                                <select name="permissions" id="permissions" class="form-control" required>
                                    <option value="edit">Can Edit</option>
                                    <option value="view">Can View</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Generate URL</button>
                        </form>
                        @if (session('share_url'))
                            <div class="mt-3">
                                <label for="share_url" class="form-label">URL Berbagi</label>
                                <input type="text" id="share_url" class="form-control"
                                    value="{{ session('share_url') }}" readonly>
                                <div class="mt-2">
                                    <a href="{{ session('share_url') }}" target="_blank" class="btn btn-primary">Lihat Preview</a>
                                    <button class="btn btn-success" onclick="copyToClipboard()">Salin URL</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("share_url");
        navigator.clipboard.writeText(copyText.value)
            .then(() => {
                alert("URL disalin: " + copyText.value);
            })
            .catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
    }
</script>
</script>
