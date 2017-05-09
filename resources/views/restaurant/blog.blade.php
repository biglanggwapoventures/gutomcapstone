@extends('restaurant.layout', compact('restaurant'))

@section('section')
@forelse($restaurant->posts AS $post)
<div class="box">
    <div class="box-content clearfix">
        <a href="{{ $post->photo }}" data-fancybox="blog" data-caption="{{ $post->title }}" >
            <img src="{{ $post->photo }}" class="pull-left img-thumbnail" alt="{{ $post->title }}"  style="height: 150px;margin-right: 10px;;">
        </a>
        <h1 class="tag-title" style="margin-top:0px">{{ $post->title }} <small>{{ date_create($post->created_at)->format('F d, Y') }}</small></h1>
        <hr />
        <p> 
            {{ $post->body }}
        </p>
    </div>
</div>
@empty
<div class="alert alert-warning text-center">
    No posts recorded
</div>
@endforelse
@endsection