@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    @include('customer.hero')
    @include('customer.featured')
    @include('customer.qualities')

@endsection
