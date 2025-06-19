@extends('user.layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            @if (isset($project))
                <a href="{{ route('projects.show', $project->slug) }}"
                    class="btn btn-outline-secondary btn-sm me-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <h3 class="mb-0 fw-bold">Create Task for {{ $project->name }}</h3>
            @else
                <h3 class="mb-0 fw-bold text-danger">Error: Project Not Found</h3>
            @endif
        </div>

        <!-- Error Handling -->
        @if (!isset($project))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Unable to create a task because the project could not be found. Please check the project details or contact
                support.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('user.tasklist.store') }}" method="POST" id="form-store">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- Task Name -->
                        <div class="mb-3">
                            <label for="list-items" class="form-label fw-bold">Task Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('list_items') is-invalid @enderror"
                                id="list-items" name="list_items" value="{{ old('list_items') }}" required>
                            @error('list_items')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Task Details -->
                        <div class="mb-3">
                            <label for="detail-list" class="form-label fw-bold">Task Details</label>
                            <textarea class="form-control @error('detail_list') is-invalid @enderror" id="detail-list" name="detail_list"
                                rows="5">{{ old('detail_list') }}</textarea>
                            @error('detail_list')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status and Priority -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label fw-bold">Priority</label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority"
                                    name="priority">
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Assign Users -->
                        <div class="mb-3">
                            <label for="tag" class="form-label fw-bold">Assign Users (Optional)</label>
                            <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag[]"
                                multiple aria-label="Select users to assign">
                                @foreach ($project->sharedProjects as $shared)
                                    @if ($shared->user)
                                        <option value="{{ $shared->user->id }}"
                                            {{ in_array($shared->user->id, old('tag', [])) ? 'selected' : '' }}>
                                            {{ $shared->user->name }} ({{ $shared->permissions }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($project->sharedProjects->isEmpty())
                                <small class="form-text text-muted">No users are assigned to this project.</small>
                            @endif
                            @error('tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Note -->
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Note</label>
                            <textarea type="text" class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                value="{{ old('note') }}" aria-label="With textarea"></textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start-date" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start-date" name="start_date" min="{{ $project->start_date }}"
                                    max="{{ $project->end_date }}" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end-date" class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end-date" name="end_date" min="{{ $project->start_date }}"
                                    max="{{ $project->end_date }}" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('projects.show', $project->slug) }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success" id="btn-submit">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: 'textarea#detail-list',
            skin: 'bootstrap',
            icons: 'bootstrap',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
            toolbar: 'undo redo | bold italic | bullist numlist | link image',
            toolbar_mode: 'floating',
            menubar: false,
            height: 200,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        // Initialize Select2
        $(document).ready(function() {
            $('#tag').select2({
                placeholder: 'Select users to assign',
                allowClear: true,
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) return data.text;
                    return $('<span>' + data.text + '</span>');
                }
            });
        });

        // Form submission with confirmation
        document.getElementById('form-store').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Save Task?',
                text: 'Are you sure you want to create this task?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Success message
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0d6 рекомендуется
                });
            });
        @endif

        // Date constraints
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');
            const projectStartDate = "{{ $project->start_date ?? '' }}";
            const projectEndDate = "{{ $project->end_date ?? '' }}";

            if (startDateInput && endDateInput) {
                startDateInput.setAttribute('min', projectStartDate);
                startDateInput.setAttribute('max', projectEndDate);
                endDateInput.setAttribute('min', projectStartDate);
                endDateInput.setAttribute('max', projectEndDate);

                startDateInput.addEventListener('change', function() {
                    endDateInput.setAttribute('min', this.value || projectStartDate);
                });

                endDateInput.addEventListener('change', function() {
                    startDateInput.setAttribute('max', this.value || projectEndDate);
                });
            }
        });
    </script>
@endsection
