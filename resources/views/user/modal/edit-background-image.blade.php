<div class="modal fade" id="editBackgroundImage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Background</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-fill" id="backgroundTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="template-tab" data-bs-toggle="tab"
                            data-bs-target="#template-tab-pane" type="button" role="tab">
                            Template
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-tab-pane"
                            type="button" role="tab">
                            Upload
                        </button>
                    </li>
                </ul>

                <!-- Tab content -->
                <div class="tab-content p-3 border border-top-0 rounded-bottom" id="backgroundTabContent">
                    <!-- Template Tab -->
                    <div class="tab-pane fade show active" id="template-tab-pane" role="tabpanel">
                        <div class="row">
                            @foreach (File::files(public_path('img/bgImg')) as $file)
                                <div class="col-md-4 mb-3">
                                    <div class="template-card card">
                                        <input type="radio" name="background_option"
                                            value="{{ $file->getFilename() }}" id="template_{{ $loop->index }}"
                                            class="d-none">
                                        <label for="template_{{ $loop->index }}" class="h-100">
                                            <img src="{{ asset('img/bgImg/' . $file->getFilename()) }}"
                                                class="card-img-top h-100 object-fit-cover"
                                                style="height: 120px; cursor: pointer;"
                                                onclick="previewTemplate(this.src)">
                                            <div class="card-body text-center p-2">
                                                <small class="text-muted">Template {{ $loop->iteration }}</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Upload Tab -->
                    <div class="tab-pane fade" id="upload-tab-pane" role="tabpanel">
                        <form id="uploadForm" action="{{ route('user.project.updateBackground', $project->id) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div id="drop-area" class="border border-primary rounded-3 p-5 text-center bg-light"
                                style="cursor: pointer; min-height: 200px;"
                                ondragover="event.preventDefault(); $(this).addClass('border-danger');"
                                ondragleave="$(this).removeClass('border-danger');" ondrop="handleDrop(event)">

                                <label for="background_project" class="form-label d-block">
                                    <i class="material-symbols-rounded display-4 text-muted">image</i><br>
                                    Drag & Drop or Click to Upload<br>
                                    <small class="text-muted">Recommended size: 1920x300px (Max: 2MB)</small>
                                </label>
                                <input class="form-control d-none" type="file" id="background_project"
                                    name="background_project" accept="image/*" onchange="previewImage(event)">
                                <div id="preview-container" class="mt-3 text-center"></div>
                            </div>
                            <input type="hidden" name="background_type" value="upload">
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="removeBackground()">
                    Remove Background
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitBackground()">
                    Apply Background
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Background Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="previewImageLarge" class="img-fluid" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                    onclick="submitBackground()">
                    Use This Background
                </button>
            </div>
        </div>
    </div>
</div>
