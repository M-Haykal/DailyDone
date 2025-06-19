@extends('tes.tes')

@section('title', 'Dashboard')
@section('content')

    {{-- <div class="card mb-5">
        <div class="card-body p-4">
            <h3 class="mb-3">Program Title</h3>
            <p class="small mb-0"> deskripsi hahahah <span class="mx-2">|</span> Created by
                <strong>MDBootstrap</strong> on 11 April , 2021
            </p>
            <hr class="my-4">
            <div class="d-flex justify-content-start align-items-center">
                <p class="mb-0 text-uppercase"><i class="fas fa-cog me-2"></i> <span class="text-muted small">settings</span>
                </p>
                <p class="mb-0 text-uppercase"><i class="fas fa-link ms-4 me-2"></i> <span class="text-muted small">program
                        link</span></p>
                <p class="mb-0 text-uppercase"><i class="fas fa-ellipsis-h ms-4 me-2"></i> <span
                        class="text-muted small">program link</span>
                    <span class="ms-3 me-4">|</span>
                </p>
                <div class="avatar-stack">
                    <span class="avatar">+6</span>
                    <img class="avatar" src="https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png" />
                    <img class="avatar" src="/images/avatar/2.jpg" />
                    <img class="avatar" src="/images/avatar/4.jpg" />
                    <img class="avatar" src="/images/avatar/5.jpg" />
                </div>
                </a>
                <button type="button" class="btn btn-outline-dark btn-sm btn-floating">
                    <i class="fas fa-plus text-body"></i>
                </button>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0 text-uppercase text-center"><i class="fa-solid fa-folder"></i> <span
                            class="text-muted small">
                            Total Projects</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0 text-uppercase text-center"><i class="fa-solid fa-list-check"></i> <span
                            class="text-muted small">Total Tasks</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0 text-uppercase text-center"><i class="fa-solid fa-note-sticky"></i> <span
                            class="text-muted small">Total Notes</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0 text-uppercase text-center"><i class="fa-solid fa-box-archive"></i> <span
                            class="text-muted small">Total Archived</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry the Bird</td>
                                <td></td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
