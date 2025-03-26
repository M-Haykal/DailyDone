@extends('user.layouts.app')

@section('title', 'Create List Page')

@section('content')
    <div class="my-3 d-flex align-items-center">
        <a href="{{ route('projects.show', $project->id) }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Create List</h3>
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
                <div class="mb-3">
                    <label for="tag" class="form-label">Tag</label>
                    <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag[]" multiple
                        required aria-label="multiple select example">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ in_array($user->id, old('tag', [])) ? 'selected' : '' }}
                                {{ $user->id == auth()->id() }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
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
                @php
                    $minStartDate = isset($project) ? $project->start_date : '';
                    $maxEndDate = isset($project) ? $project->end_date : '';
                @endphp

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start-date" name="start_date" min="{{ $minStartDate }}" max="{{ $maxEndDate }}"
                                value="{{ old('start_date') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end-date" name="end_date" min="{{ $minStartDate }}" max="{{ $maxEndDate }}"
                                value="{{ old('end_date') }}" required>
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
    
    <script>
        ClassicEditor
            .create(document.querySelector('#detail-list'))
            .catch(error => {
                console.error(error);
            });

        document.getElementById('btn-submit').addEventListener('click', event => {
            event.preventDefault();
            document.getElementById('form-store').submit();
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

        document.addEventListener("DOMContentLoaded", function() {
            let projectStartDate = "{{ $minStartDate }}";
            let projectEndDate = "{{ $maxEndDate }}";

            let startDateInput = document.getElementById('start-date');
            let endDateInput = document.getElementById('end-date');

            startDateInput.setAttribute("min", projectStartDate);
            startDateInput.setAttribute("max", projectEndDate);
            endDateInput.setAttribute("min", projectStartDate);
            endDateInput.setAttribute("max", projectEndDate);

            startDateInput.addEventListener("change", function() {
                endDateInput.setAttribute("min", this.value);
            });

            endDateInput.addEventListener("change", function() {
                startDateInput.setAttribute("max", this.value);
            });
        });
    </script>
@endsection

