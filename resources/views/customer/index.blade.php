@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    @include('customer.hero')
    @include('customer.featured')
    @include('customer.qualities')
    {{--
    @include('customer.cart_wishlist')
    @include('customer.orders')
    @include('customer.categories')
    @include('customer.notifications') --}}
@endsection
