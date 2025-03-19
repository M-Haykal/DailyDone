@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    <img src="{{ asset('img/errors/401.png') }}" alt="" srcset="" class="img-fluid">
@endsection
