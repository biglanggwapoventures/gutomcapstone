@extends('layouts.app')

@push('styles')
<style type="text/css">
    
</style>
@endpush

@section('title', 'Gutom - Cebu Restaurant Portal')

@section('content')

    @include('partials.navbar')

    <div class="container-fluid" style="margin-top:-22px;">
        @include('partials.search')
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h3 style="font-weight:bold">Cebu Restaurants</h3>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-sm-10 col-sm-offset-1">
            
                <div class="row">
                    
                    <div class="col-sm-10" style="border-right:1px dashed #a7a7a7">
                        @if($results->isEmpty())
                            <div class="bs-callout bs-callout-danger" style="background:#fff">
                                No results found.
                            </div>
                        @endif
                        <div class="row">
                            @foreach($results->chunk(ceil($results->count() / 2)) AS $group)
                                <div class="col-sm-6">
                                    @forelse($group AS $result)
                                        <div class="gutom-card">
                                            <div class="row">
                                                <div class="col-sm-12" >
                                                    <div class="media">
                                                        <div class="media-left">
                                                            <div class="media-object" style="background-image: url({{ $result->logo }})">
                                                                <a href="{{ url('restaurant', ['id' => $result->id])}}" class="link"></a>
                                                            </div>
                                                        </div>
                                                        <div class="media-body">
                                                           <div class="pull-right">
                                                                @if($result->average_rating)
                                                                    
                                                                    {!! Form::selectRange('rating', 1, 5, 0, ['class' => 'restaurant-rating', 'data-avg-rating' => $result->average_rating ]); !!}
                                                                @else
                                                                    
                                                                @endif
                                                           </div>
                                                            <small class="categories">{{ implode(', ', $result->categoriesFlatArray()) }}</small>
                                                            <a href="{{ url('restaurant', ['id' => $result->id])}}" class="media-header-wrapper">
                                                                <h4 class="media-heading">{{ $result->name }}</h4>
                                                            </a>
                                                            {{ $result->address }}
                                                        </div>
                                                    </div>
                                                    <table class="details">
                                                        <tr>
                                                            <td>CUISINES</td>
                                                            <td>{{ implode(', ', $result->cuisinesFlatArray()) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CONTACT</td>
                                                            <td>{{ $result->contact_number }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @empty


                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-2 hidden-xs">
                        <div class="row">
                            <div class="col-sm-12">
                                @foreach($ads AS $a)
                                    <div class="food-card clearfix">
                                        <img src="{{ $a->photo }}" style="border-radius:4px;width:100%;height:auto">
                                        <div class="details cleafix">
                                            <h5 style="margin:0 0 5px 0">{{ $a->title }}</h5>
                                            <p style="color:#a7a7a7;font-size:80%">{{ $a->description }}</p>
                                            <small class="pull-right text-warning"><em>by: {{ $a->restaurant->name }}</em></small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.restaurant-rating').each(function(){
                var rating = $(this).data('avg-rating');
                $(this).barrating({
                    theme: 'fontawesome-stars-o',
                    readonly: true,
                    initialRating: rating
                });
            })
        })
    </script>
@endpush