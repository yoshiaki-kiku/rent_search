@extends('layouts.base')

@section('content')

<div class="container my-1 px-0 py-2">
    <h1>検索結果 {{ $propertyCount }} 件</h1>
</div>

<!-- option_listがオプションリスト -->

@foreach ($properties as $property)
<div class="container bg-white border shadow mb-3">
    <h2 class="mt-2">
        ID「{{ $property->id }}」の賃貸物件
    </h2>
    <div class="d-flex mb-2">
        <div class="pr-3">
            <div style="width:250px;height:200px;">
                <img data-src="holder.js/250x200?text=賃貸物件の画像&theme=sky&size=16">
            </div>
        </div>
        <div class="flex-grow-1 rent-info">
            <table class="table table-bordered">
                <tr>
                    <td style="width:125px;" class="my-bg-secondary">賃料</td>
                    <td>{{ $property->rent }} 円</td>
                </tr>
                <tr>
                    <td class="my-bg-secondary">地域</td>
                    <td>{{ $property->rentalArea->name }}</td>
                </tr>
                <tr>
                    <td class="my-bg-secondary">住所</td>
                    <td>{{ $property->adress }}</td>
                </tr>
                <tr>
                    <td class="my-bg-secondary">築年数 / 間取り</td>
                    <td>
                        @if ($property->age == 0)
                        新築
                        @else
                        {{ $property->age }}年
                        @endif
                        / {{ $property->rentalFloorPlan->name }}
                    </td>
                </tr>
                <tr>
                    <td class="my-bg-secondary">オプション</td>
                    <td>
                        @foreach($property->option_list as $optionId)
                        <span class="badge badge-secondary p-1">
                            {{ $optionList[$optionId] }}
                        </span>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endforeach

<div class="d-flex justify-content-center">
    {{ $properties->appends($query)->links() }}
</div>


@endsection
