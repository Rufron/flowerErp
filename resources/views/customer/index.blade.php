@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
    @include('customer.hero')
    @include('customer.qualities')
    @include('customer.featured')
    @include('customer.cart_wishlist')
    @include('customer.orders')
    @include('customer.categories')
    @include('customer.notifications')
@endsection
