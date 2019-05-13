@extends('layouts.base')

@section('content')
<nav class="navbar fixed-top navbar-dark bg-secondary">
    <a class="navbar-brand" href="#!">賃貸検索</a>
</nav>

<div class="container my-1 px-0 py-2">
    <h1>賃貸物件を探す</h1>
</div>

<div class="container mt-2 mb-4 p-4 border shadow">
    <rent-search-form-component
        v-bind:init-rental-floor-plans="{{ $rentalFloorPlans }}"
        v-bind:init-rental-areas="{{ $rentalAreas }}">
    </rent-search-form-component>
</div>

@endsection
