@extends('user.layouts.app')

@section('title', 'Create List Page')

@section('content')
    <div class="my-3 d-flex align-items-center">
        <a href="{{ url()->previous() }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Create List</h3>
    </div>
    <div class="card">
        <div class="m-3">
            {{-- @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.tasklist.store') }}" method="POST" id="form-store">
                @csrf
                <div class="mb-3 input-group input-group-outline">
                    <label for="list-items" class="form-label">List Items</label>
                    <input type="text" class="form-control @error('list_items') is-invalid @enderror" id="list-items"
                        name="list_items" value="{{ old('list_items') }}" required>
                    @error('list_items')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="detail-list" class="form-label">Detail List</label>
                    <textarea class="form-control @error('detail_list') is-invalid @enderror" id="detail-list" name="detail_list"
                        rows="3">{{ old('detail_list') }}</textarea>
                    @error('detail_list')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                            In
                            Progress</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium
                        </option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="tag" value="{{ auth()->user()->name }}">
                <div class="mb-3 input-group input-group-outline">
                    <label for="note" class="form-label">Note</label>
                    <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                        name="note" value="{{ old('note') }}" required>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start-date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end-date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @if (isset($project))
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                @else
                    <p>Error: Project ID tidak ditemukan.</p>
                @endif

                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mx-1">Close</a>
                    <button type="submit" class="btn btn-success mx-1" id="btn-submit">Save changes</button>
                </div>
            </form>
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

        document.getElementById('btn-submit').addEventListener('click', event => {
            event.preventDefault();
            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak dapat membatalkan ini!",
                icon: 'peringatan',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-store').submit();
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
