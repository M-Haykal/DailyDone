@extends('user.layouts.app')

@section('title', 'Edit Profile')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0 text-white">Edit Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="text-center mb-4">
                                <div id="drop-area" class="border border-primary rounded-3 p-3" style="cursor: pointer;">
                                    <img src="{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}"
                                        alt="profile_image" class="rounded-circle border border-3 border-primary"
                                        id="preview-image" style="width: 150px; height: 150px; object-fit: cover;">
                                    <p class="text-muted mt-2">Drag & Drop or Click to Upload</p>
                                    <p class="text-muted">Max dimension 400px x 400px</p>
                                </div>
                                <input type="file" class="form-control d-none" name="image_profile" id="image_profile"
                                    accept="image/*" onchange="handleInputFile(this)">
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
                    previewImage.src = "{{ auth()->user()->image_profile ? url('storage/images/' . auth()->user()->image_profile) : Avatar::create(auth()->user()->name)->toBase64() }}";
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

