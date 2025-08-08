@extends('user.layouts.app')

@section('title', 'Profile')
@section('content')
    <div class="container-fluid px-2 px-md-4">
        <ul class="nav nav-fill nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#profile-user" role="tab"
                    aria-controls="profile-user" aria-selected="true"> Profile </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#edit-profile-user" role="tab"
                    aria-controls="edit-profile-user" aria-selected="false"> Edit Profile </a>
            </li>
        </ul>
        <div class="tab-content pt-5" id="tab-content">
            <div class="tab-pane active" id="profile-user" role="tabpanel" aria-labelledby="fill-tab-0">
                <div class="row mx-2 mx-md-2 mt-n6">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}"
                                        alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                </div>
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{ auth()->user()->name }}
                                    </h5>
                                    <p class="mb-0 font-weight-normal text-sm">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Profile Information</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="{{ route('user.profile.edit') }}">
                                            <i class="fa-solid fa-user-pen text-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit Profile"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full
                                            Name:</strong> &nbsp; {{ auth()->user()->name }}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Email:</strong>
                                        &nbsp; {{ auth()->user()->email }}</li>
                                    {{-- <li class="list-group-item border-0 ps-0 pb-0">
                                <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-facebook fa-lg"></i>
                                </a>
                                <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-twitter fa-lg"></i>
                                </a>
                                <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                    <i class="fab fa-instagram fa-lg"></i>
                                </a>
                            </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="edit-profile-user" role="tabpanel" aria-labelledby="fill-tab-1">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg border-0">
                            <div class="card-header bg-primary">
                                <a href="{{ url()->previous() }}" class="text-decoration-none me-3 text-white">
                                    <i class="material-symbols-rounded fs-4">arrow_back</i>
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('user.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="text-center mb-4">
                                        <div id="drop-area" class="border border-primary rounded-3 p-3"
                                            style="cursor: pointer;">
                                            <img src="{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}"
                                                alt="profile_image" class="rounded-circle border border-3 border-primary"
                                                id="preview-image" style="width: 150px; height: 150px; object-fit: cover;">
                                            <p class="text-muted mt-2">Drag & Drop or Click to Upload</p>
                                            <p class="text-muted">Max dimension 400px x 400px</p>
                                        </div>
                                        <input type="file" class="form-control d-none" name="image_profile"
                                            id="image_profile" accept="image/*" onchange="handleInputFile(this)">
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ auth()->user()->name }}" required>
                                                <label>Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ auth()->user()->email }}" required>
                                                <label>Email</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password & Confirm Password -->
                                    <div class="row g-3 mt-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" name="password">
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" name="password_confirmation">
                                                <label>Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success w-100">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-dark  opacity-6"></span>
        </div>

    </div>
@endsection

@section('script')
    <script>
        const imageInput = document.getElementById('image_profile');
        const previewImage = document.getElementById('preview-image');
        const dropArea = document.getElementById('drop-area');

        imageInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        dropArea.addEventListener('click', function() {
            imageInput.click();
        });

        dropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropArea.classList.add('border-primary', 'border-3');
        });

        dropArea.addEventListener('dragleave', function() {
            dropArea.classList.remove('border-primary', 'border-3');
        });

        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            dropArea.classList.remove('border-primary', 'border-3');
            let files = e.dataTransfer.files;
            imageInput.files = files;
            handleFiles(files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    checkImageDimension(event.target.result);
                }
                reader.readAsDataURL(files[0]);
            }
        }

        function checkImageDimension(dataURL) {
            let img = new Image();
            img.onload = function() {
                if (this.width !== 400 || this.height !== 400) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Image must be 400x400',
                        confirmButtonColor: '#3085d6'
                    });
                    imageInput.value = "";
                    previewImage.src =
                        "{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}";
                }
            };
            img.src = dataURL;
        }

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
