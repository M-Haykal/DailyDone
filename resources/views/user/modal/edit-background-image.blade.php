<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Edit Background Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="data-background-tab" data-bs-toggle="tab"
                    data-bs-target="#data-background" type="button" role="tab" aria-controls="data-background"
                    aria-selected="true">Data Background</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="create-background-tab" data-bs-toggle="tab"
                    data-bs-target="#create-background" type="button" role="tab" aria-controls="create-background"
                    aria-selected="false">Create Background</button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="data-background" role="tabpanel"
                aria-labelledby="data-background-tab">
                <h1>Data Background</h1>
            </div>
            <div class="tab-pane fade" id="create-background" role="tabpanel" aria-labelledby="create-background-tab">
                <h1>Create background</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="image_project" class="form-label">Image Project</label>
                        <input class="form-control @error('image_project') is-invalid @enderror" type="file"
                            id="image_project" name="image_project" required>
                        @error('image_project')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
