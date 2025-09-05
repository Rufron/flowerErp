@extends('layouts.app')

@section('title', 'Home')

@section('header')
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        {{-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Brand A</a></li> --}}
        {{-- <li class="nav-item"><a class="nav-link" href="#!">Brand B</a></li> --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Brand A</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">All Products</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#!">Best</a></li>
                <li><a class="dropdown-item" href="#!">Better</a></li>
                <li><a class="dropdown-item" href="#!">Good</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Brand B</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">All Products</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#!">Best</a></li>
                <li><a class="dropdown-item" href="#!">Better</a></li>
                <li><a class="dropdown-item" href="#!">Good</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Brand C</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">All Products</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="#!">Best</a></li>
                <li><a class="dropdown-item" href="#!">Better</a></li>
                <li><a class="dropdown-item" href="#!">Good</a></li>
            </ul>
        </li>
    </ul>
    <form class="d-flex">
        <button class="btn btn-outline-dark" type="submit">
            <i class="bi-cart-fill me-1"></i>
            Cart
            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
        </button>
    </form>
</div>
@endsection
