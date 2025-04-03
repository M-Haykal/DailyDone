@extends('user.layouts.app')

@section('title', 'Edit Task List Page')

@section('content')
    <div class="container py-4">
        <!-- Back button and title -->
        <div class="d-flex align-items-center mb-4">
            <a href="{{ url()->previous() }}" class="text-decoration-none me-3">
                <i class="material-symbols-rounded fs-4">arrow_back</i>
            </a>
            <h1 class="h4 mb-0 fw-bold">Edit Task List</h1>
        </div>

        <!-- Main card -->
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
                    <div class="mb-4">
                        <label for="list-items" class="form-label fw-semibold">List Items</label>
                        <input type="text" class="form-control @error('list_items') is-invalid @enderror" id="list-items"
                            name="list_items" value="{{ old('list_items', $tasklist->list_items) }}" required>
                        @error('list_items')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Detail List -->
                    <div class="mb-4">
                        <label for="detail-list" class="form-label fw-semibold">Detail List</label>
                        <textarea class="form-control @error('detail_list') is-invalid @enderror" id="detail-list" name="detail_list"
                            rows="4">{{ old('detail_list', $tasklist->detail_list) }}</textarea>
                        @error('detail_list')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tag and Note -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="tag" class="form-label fw-semibold">Tag</label>
                            <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag[]"
                                multiple required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ is_array(old('tag', json_decode($tasklist->tag, true))) && in_array($user->id, old('tag', json_decode($tasklist->tag, true))) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="note" class="form-label fw-semibold">Note</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                                name="note" value="{{ old('note', $tasklist->note) }}" required>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="start-date" class="form-label fw-semibold">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start-date" name="start_date" value="{{ old('start_date', $tasklist->start_date) }}"
                                required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end-date" class="form-label fw-semibold">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end-date" name="end_date" value="{{ old('end_date', $tasklist->end_date) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="project_id" value="{{ $tasklist->project_id }}">
                    <input type="hidden" name="user_id" value="{{ $tasklist->user_id }}">

                    <!-- Form buttons -->
                    <div class="d-flex justify-content-end pt-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="btn-update">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#detail-list'))
            .catch(error => {
                console.error(error);
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
