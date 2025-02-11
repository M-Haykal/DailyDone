@extends('user.layouts.app')

@section('title', 'Create List Page')

@section('content')
    <div class="card">
        <div class="m-3">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.tasklist.store') }}" method="POST">
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
                <div class="mb-3 input-group input-group-outline">
                    <label for="tag" class="form-label">Tag</label>
                    <input type="text" class="form-control @error('tag') is-invalid @enderror" id="tag"
                        name="tag" value="{{ old('tag') }}" required>
                    @error('tag')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group input-group-outline">
                    <label for="note" class="form-label">Note</label>
                    <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                        name="note" value="{{ old('note') }}" required>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if (isset($project))
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                @else
                    <p>Error: Project ID tidak ditemukan.</p>
                @endif

                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mx-1">Close</a>
                    <button type="submit" class="btn btn-success mx-1">Save changes</button>
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
    </script>
@endsection

