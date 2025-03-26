@extends('user.layouts.app')

@section('title', 'Edit Task List Page')

@section('content')
    <div class="my-3 d-flex align-items-center">
        <a href="{{ url()->previous() }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Edit Task List</h3>
    </div>
    <div class="card">
        <div class="m-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
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
                <div class="mb-3 input-group input-group-outline">
                    <label for="list-items" class="form-label">List Items</label>
                    <input type="text" class="form-control @error('list_items') is-invalid @enderror" id="list-items"
                        name="list_items" value="{{ old('list_items', $tasklist->list_items) }}" required>
                    @error('list_items')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="detail-list" class="form-label">Detail List</label>
                    <textarea class="form-control @error('detail_list') is-invalid @enderror" id="detail-list" name="detail_list"
                        rows="3">{{ old('detail_list', $tasklist->detail_list) }}</textarea>
                    @error('detail_list')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag</label>
                            <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag[]"
                                multiple required aria-label="multiple select example">
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
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 input-group input-group-outline">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                                name="note" value="{{ old('note', $tasklist->note) }}" required>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start-date" name="start_date" value="{{ old('start_date', $tasklist->start_date) }}"
                                required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end-date" name="end_date" value="{{ old('end_date', $tasklist->end_date) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <input type="hidden" name="project_id" value="{{ $tasklist->project_id }}">
                <input type="hidden" name="user_id" value="{{ $tasklist->user_id }}">

                <div class="modal-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary mx-1">Close</a>
                    <button type="submit" class="btn btn-success mx-1" id="btn-update">Save changes</button>
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

        document.getElementById('btn-update').addEventListener('click', event => {
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
