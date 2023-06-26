@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    @include('admin.dashboard.small_box')
    {{-- @include('admin.dashboard.slider') --}}
@endsection
