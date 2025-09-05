@extends('layouts.admin')

@section('content')
  <!-- 1. Key Metrics -->
  @include('admin.partials._cards')

  <!-- 2. Inventory -->
  @include('admin.partials._inventory')

  <!-- 3. Orders Overview -->
  @include('admin.partials._orders')

  <!-- 4. Customer Overview -->
  @include('admin.partials._customers')

  <!-- 5. Sales Chart -->
  @include('admin.partials._salesChart')

  <!-- 6. Quick Actions -->
  @include('admin.partials._quickActions')
@endsection
