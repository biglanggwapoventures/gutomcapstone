@extends('restaurant.layout', compact('restaurant'))

@section('section')
<div style="margin-top:20px">
    
    @forelse($restaurant->photos->chunk(4) AS $photos)
        <div class="row">
            @foreach($photos AS $p)
            <div class="col-sm-3">
                <div class="thumbnail">
                    <div style="height:150px;overflow:hidden;background: url({{ $p->full_path }}) center center;background-size:cover">
                        <a href="{{ $p->full_path }}" data-fancybox="media" data-caption="{{ $restaurant->name}}" style="display:block;height:100%">
                            &nbsp;
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @empty
    <div class="alert alert-warning text-center">
        No photos recorded
    </div>
</div>
@endforelse
@endsection