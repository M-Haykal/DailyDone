@extends('user.layouts.app')

@section('title', 'Trashs')

@section('content')
    <div class="main-header bg-gradient-primary p-4 rounded-3 mb-5 shadow-sm">
        <h2 class="mb-0">Trash Project</h2>
    </div>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Project Name</th>
                        <th width="25%" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('user.projects.restore', $project->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-trash-restore"></i> Restore
                                    </button>
                                </form>

                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDelete(event, {{ $project->id }})">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>

                                <form id="delete-form-{{ $project->id }}"
                                    action="{{ route('user.projects.forceDelete', $project->id) }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{ asset('img/data-empety.png') }}" alt="No projects in archive"
                                        class="img-fluid" style="max-width: 300px">
                                    <h5 class="text-muted">No projects in trash</h5>
                                    <p class="text-muted">Deleted projects will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(event, projectId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the project!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${projectId}`).submit();
                }
            });
        }
    </script>
@endsection
