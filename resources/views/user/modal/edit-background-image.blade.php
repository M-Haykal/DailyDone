<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">Edit Background Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            {{-- <li class="nav-item" role="presentation">
                <a class="nav-link active" id="template-background-tab" data-bs-toggle="tab"
                    href="{{ route('user.backgroundProjects.index', ['project_id' => $project->id]) }}" role="tab"
                    aria-controls="template-background" aria-selected="true">Template Background</a>
            </li> --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="template-background-tab" data-bs-toggle="tab"
                    data-bs-target="#template-background" type="button" role="tab"
                    aria-controls="template-background" aria-selected="true">
                    Template Background
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="create-background-tab" data-bs-toggle="tab"
                    data-bs-target="#create-background" type="button" role="tab" aria-controls="create-background"
                    aria-selected="false">Edit Background</button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="template-background" role="tabpanel"
                aria-labelledby="template-background-tab">
                <div class="row">
                    @if ($project->backgroundProjects)
                        @foreach ($project->backgroundProjects as $background)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="shadow-1-strong rounded" data-ripple-color="light">
                                    <img src="{{ asset('storage/bgProject/' . $background->image_project) }}"
                                        class="img-fluid" alt="Background Image" />
                                    <p>{{ $background->id }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="create-background" role="tabpanel" aria-labelledby="create-background-tab">
                <h1>Edit background</h1>
                <form action="{{ route('user.backgroundProjects.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <div id="drop-area" class="border border-primary rounded-3 p-3 text-center bg-light"
                            style="cursor: pointer;" ondragover="event.preventDefault()" ondrop="handleDrop(event)">
                            <label for="image_project" class="form-label">Drag & Drop or Click to Upload</label>
                            <input class="form-control d-none" type="file" id="image_project" name="image_project"
                                accept="image/*" required onchange="previewImage(event)">
                            <div id="preview-container" class="mt-2"></div>
                        </div>
                    </div>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("drop-area").addEventListener("click", function() {
        document.getElementById("image_project").click();
    });

    function handleDrop(event) {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        document.getElementById("image_project").files = event.dataTransfer.files;
        previewImage({
            target: {
                files: [file]
            }
        });
    }

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewContainer = document.getElementById("preview-container");
                previewContainer.innerHTML = ""; // Menghapus pratinjau lama sebelum menampilkan yang baru
                previewContainer.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" width="200">`;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
