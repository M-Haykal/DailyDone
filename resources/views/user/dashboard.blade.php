@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container p-2">
        <div class="main-header bg-warning p-4 rounded-3 mb-5 shadow-sm">
            <div>
                <h3 class="mb-0 h4 font-weight-bold">Hello, John Doe</h3>
                <p class="text-sm mb-0">Welcome to your dashboard!</p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
   
@endsection
