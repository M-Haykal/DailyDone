@extends('user.layouts.app')

@section('title', 'Detail List')

@section('content')
    <div class="my-3 d-flex align-items-center">
        <a href="{{ url()->previous() }}"><i class="material-symbols-rounded">arrow_back</i></a>
        <h3 class="mb-0 h4 font-weight-bolder mx-2">Detail Task List</h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title">{{ $taskList->list_items }}</h3>
            <p class="card-text">{!! $taskList->detail_list !!}</p>
            <div class="row">
                <div class="col-6">
                    <strong>Status:</strong>
                    @switch($taskList->status)
                        @case('pending')
                            <span class="badge rounded-pill bg-danger">{{ $taskList->status }}</span>
                            @break
                        @case('in_progress')
                            <span class="badge rounded-pill bg-warning">{{ $taskList->status }}</span>
                            @break
                        @case('completed')
                            <span class="badge rounded-pill bg-success">{{ $taskList->status }}</span>
                            @break
                    @endswitch
                </div>
                <div class="col-6">
                    <strong>Priority:</strong>
                    @switch($taskList->priority)
                        @case('high')
                            <span class="badge rounded-pill bg-danger">{{ $taskList->priority }}</span>
                            @break
                        @case('medium')
                            <span class="badge rounded-pill bg-warning">{{ $taskList->priority }}</span>
                            @break
                        @case('low')
                            <span class="badge rounded-pill bg-success">{{ $taskList->priority }}</span>
                            @break
                    @endswitch
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <strong>Tag:</strong> {{ $taskList->tag }}
                </div>
                <div class="col-6">
                    <strong>Note:</strong> {{ $taskList->note }}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <strong>Start Date:</strong> {{ $taskList->start_date }}
                </div>
                <div class="col-6">
                    <strong>End Date:</strong> {{ $taskList->end_date }}
                </div>
            </div>
        </div>
    </div>
@endsection
