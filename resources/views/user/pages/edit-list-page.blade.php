@extends('user.layouts.app')

@section('title', 'Edit Task Page')

@section('content')
    <div class="container py-4">
        <!-- Back button and title -->
        <div class="d-flex align-items-center mb-4">
            @if (isset($tasklist))
                <a href="{{ url()->previous() }}"
                    class="btn btn-outline-secondary btn-sm me-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <h3 class="mb-0 fw-bold">Edit Task {{ $tasklist->list_items }}</h3>
            @else
                <h3 class="mb-0 fw-bold">Error: Tasklist Not Found</h3>
            @endif
        </div>

        @if (!isset($tasklist))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Unable to Edit a task because the Tasklist could not be found. Please check the Tasklist details or contact
                support.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.tasklist.edit', [$tasklist->project_id, $tasklist->id]) }}" method="POST"
                        id="form-update">
                        @csrf
                        @method('PUT')

                        <!-- List Items -->
                        <div class="mb-3">
                            <label for="list-items" class="form-label fw-bold">Task Name</label>
                            <input type="text" class="form-control @error('list_items') is-invalid @enderror"
                                id="list-items" name="list_items" value="{{ old('list_items', $tasklist->list_items) }}"
                                required>
                            @error('list_items')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Detail List -->
                        <div class="mb-3">
                            <label for="detail-list" class="form-label fw-bold">Detail Task</label>
                            <textarea class="form-control @error('detail_list') is-invalid @enderror" id="detail-list" name="detail_list"
                                rows="5">{{ old('detail_list', $tasklist->detail_list) }}</textarea>
                            @error('detail_list')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tag" class="form-label fw-bold">Tag</label>
                            <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag[]"
                                multiple required aria-label="Select users to assign">
                                @foreach ($tasklist->project->sharedProjects as $shared)
                                    @if ($shared->user)
                                        <option value="{{ $shared->user->id }}"
                                            {{ in_array($shared->user->id, old('tag', json_decode($tasklist->tag, true) ?? [])) ? 'selected' : '' }}>
                                            {{ $shared->user->name }} ({{ $shared->permissions }})
                                        </option>
                                    @endif
                                @endforeach

                            </select>
                            @if ($tasklist->project->sharedUsers->isEmpty())
                                <small class="form-text text-muted">No users are assigned to this project.</small>
                            @endif
                            @error('tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Note</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" required>{{ old('note', $tasklist->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start-date" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start-date" name="start_date"
                                    value="{{ old('start_date', $tasklist->start_date) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end-date" class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end-date" name="end_date" value="{{ old('end_date', $tasklist->end_date) }}"
                                    required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" name="project_id" value="{{ $tasklist->project_id }}">
                        <input type="hidden" name="user_id" value="{{ $tasklist->user_id }}">

                        <!-- Form buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-success" id="btn-update">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#detail-list',
            skin: 'bootstrap',
            icons: 'bootstrap',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            menubar: false,
        });

        $('#tag').select2({
            placeholder: 'Select users to assign',
            allowClear: true,
            width: '100%',
            templateResult: function(data) {
                if (!data.id) return data.text;
                return $('<span>' + data.text + '</span>');
            }
        });

        document.getElementById('btn-update').addEventListener('click', event => {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-update').submit();
                }
            });
        });

        @if (session('success'))
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6'
                });
            });
        @endif
    </script>
@endsection
