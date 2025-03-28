<div class="modal fade" id="note-project" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Completion Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.saveNote', $project->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if ($project->end_date->isPast())
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Project ini telah melewati deadline pada {{ $project->end_date->format('d F Y') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="project_note" class="form-label">Berikan catatan tentang project ini:</label>
                        <textarea class="form-control" id="project_note" name="note" rows="5"
                            placeholder="Mengapa project tidak selesai? Apa kendalanya?">{{ $project->note }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                </div>
            </form>
        </div>
    </div>
</div>
