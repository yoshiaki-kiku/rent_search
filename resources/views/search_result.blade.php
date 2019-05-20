@extends('layouts.base')

@section('content')

<div class="container my-1 px-0 py-2">
    <h1>検索結果</h1>
</div>

@foreach ($properties as $property)
{{ $property->adress }}
@endforeach


@endsection
