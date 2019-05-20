@extends('layouts.base')

@section('content')

<div class="container my-1 px-0 py-2">
    <h1>賃貸物件を探す</h1>
</div>

<rent-search-form-component
    action-url="{{ route('search.result') }}"
    v-bind:init-area-property-count="{{ $areaPropertyCount }}"
    v-bind:init-rental-floor-plans="{{ $rentalFloorPlans }}"
    v-bind:init-rental-areas="{{ $rentalAreas }}"
    v-bind:init-rental-property-options="{{ $rentalPropertyOptions }}">
</rent-search-form-component>

@endsection
