@extends('restaurant.layout', compact('restaurant'))

@section('section')
<div class="row" style="margin-top:10px;">
@forelse($restaurant->promos->chunk(ceil($restaurant->promos->count() / 4)) AS $group)
    <div class="col-sm-3">
        @foreach($group AS $a)
            <div class="food-card clearfix">
                <img src="{{ $a->photo }}" style="border-radius:4px;width:100%;height:auto">
                <div class="details cleafix">
                    <h4 style="margin:0 0 5px 0">{{ $a->title }}</h4>
                    <p style="color:#a7a7a7;">{{ $a->description }}</p>
                    <small class="text-danger">{{ date_create($a->start_date)->format('m/d/Y') }} - {{ date_create($a->end_date)->format('m/d/Y') }}</small>
                </div>
            </div>
        @endforeach
    </div>
@empty
<div class="alert alert-warning text-center">
    No promos recorded
</div>
@endforelse
@endsection