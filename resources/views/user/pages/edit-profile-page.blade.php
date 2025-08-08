@extends('user.layouts.app')

@section('title', 'Edit Profile')
@section('content')
    <div class="container py-5">
        
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
