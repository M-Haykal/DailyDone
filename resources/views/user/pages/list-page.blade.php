@extends('user.layouts.app')

@section('title', $project->name)

@section('content')
    <div class="container mt-4">
        <h1>{{ $project->name }}</h1>
        <h2>{{ $project->description }}</h2>
        @include('user.modal.list.create-list')
        <a href="" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#createList">
            <i class="material-symbols-rounded opacity-5 mx-3">add</i>
        </a>


        <div class="row my-5">
            <!-- List Kiri (Sumber) -->
            <div class="col-md-4">
                <h4>Belum Dikerjakan</h4>
                <ul id="exampleLeft" class="list-group">
                    <li class="list-group-item">Item 1</li>
                    <li class="list-group-item">Item 2</li>
                    <li class="list-group-item">Item 3</li>
                    <li class="list-group-item">Item 4</li>
                    <li class="list-group-item">Item 5</li>
                </ul>
            </div>

            <!-- List Tengah -->
            <div class="col-md-4">
                <h4>Sedang Dikerjakan</h4>
                <ul id="exampleMiddle" class="list-group">
                    <!-- Kosong awalnya -->
                </ul>
            </div>

            <!-- List Kanan -->
            <div class="col-md-4">
                <h4>Selesai Dikerjakan</h4>
                <ul id="exampleRight" class="list-group">
                    <!-- Kosong awalnya -->
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Sortable(document.getElementById("exampleLeft"), {
                group: {
                    name: 'shared',
                    pull: true,
                    put: false
                },
                animation: 150
            });

            new Sortable(document.getElementById("exampleMiddle"), {
                group: {
                    name: 'shared',
                    pull: true,
                    put: true
                },
                animation: 150
            });

            new Sortable(document.getElementById("exampleRight"), {
                group: {
                    name: 'shared',
                    pull: true,
                    put: true
                },
                animation: 150
            });
        });
    </script>

@endsection
