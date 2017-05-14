@extends('layouts.app')

@section('title', $restaurant->name)

@push('styles')
@stack('section-styles')
@endpush

@section('content')

    @include('partials.navbar')

    <div class="container-fluid" style="margin-top:-22px;">
        @include('partials.search')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card hovercard">
                    <div class="card-background">
                        <img class="card-bkimg" alt="" src="{{ $restaurant->logo }}">
                    </div>
                    <div class="useravatar">
                        <img alt="" src="{{ $restaurant->logo }}">
                    </div>
                    <div class="card-info"> <span class="card-title">{{ $restaurant->name }} </span>
                    @if($rating = $restaurant->getAverageRating())
                        {!! Form::selectRange('', 1, 5, 0, ['id' => 'restaurant-rating', 'data-avg-rating' => $rating, 'class' => 'hidden']) !!}
                    @endif
                    </div>
                </div>
                <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
                    <div class="btn-group "  role="group">
                        <a class="btn btn-danger {{ $nav === 'overview' ? 'active' : '' }}" href="{{ route('restaurant.overview', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-user-circle fa-fw" aria-hidden="true"></span> Overview
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'menu' ? 'active' : '' }}" href="{{ route('restaurant.menu', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-book fa-fw" aria-hidden="true"></span> Menu
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'blog' ? 'active' : '' }}"  href="{{ route('restaurant.blog', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-pencil fa-fw" aria-hidden="true"></span> Blog
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'photos' ? 'active' : '' }}" href="{{ route('restaurant.photos', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-image fa-fw" aria-hidden="true"></span> Photos
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'promos' ? 'active' : '' }}" href="{{ route('restaurant.promos', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-bullhorn fa-fw" aria-hidden="true"></span> Promos
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                       <a class="btn btn-danger {{ $nav === 'ads' ? 'active' : '' }}" href="{{ route('restaurant.ads', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-bookmark-o fa-fw" aria-hidden="true"></span> Ads
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'reviews' ? 'active' : '' }}" href="{{ route('restaurant.reviews', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-check fa-fw" aria-hidden="true"></span> Reviews
                        </a>
                    </div>
                    @if(Auth::check() && Auth::user()->isStandardUser())
                    <div class="btn-group" role="group">
                        <a class="btn btn-danger {{ $nav === 'cart' ? 'active' : '' }}" href="{{ route('restaurant.cart', ['id' => $restaurant->id]) }}">
                            <span class="fa fa-shopping-cart fa-fw" aria-hidden="true"></span> My Cart
                        </a>
                    </div>
                    @endif
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade in active">
                        @yield('section')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        var avgRating = $('#restaurant-rating').data('avg-rating');
         $('#restaurant-rating').barrating({
            theme: 'fontawesome-stars-o',
            readonly: true,
            initialRating: avgRating
        });

        $('[data-hidden]').slideToggle();

        $('.item-quantity').keyup(function (e) {
            var $this = $(this),    
                btn = $this.siblings('.input-group-btn').find('button');
            if(parseInt($this.val())){
                
                if(e.keyCode === 13){
                    btn.trigger('click');
                }else{
                    btn.removeAttr('disabled');
                }
                return;
            }
            $this.siblings('.input-group-btn').find('button').attr('disabled', 'disabled');
        }).trigger('keyup');

        $('.btn-cart').click(function(){
            var $this = $(this),
                spinner = '<i class="fa fa-spin fa-spinner"></i>',  
                url = '{{ route("cart.store") }}',
                menuId = $this.data('pk'),
                quantityField =  $this.parent().siblings('.item-quantity')
                quantity = quantityField.val();

            $this.attr('disabled', 'disabled').html(spinner)
            $.post(url, { menu_id: menuId, quantity: quantity})
                .done(function () {
                    quantityField.val('').trigger('keyup');
                    new Noty({ 
                        layout: 'bottomRight',
                        text: 'Added ' + quantity + ' item(s) to cart!', 
                        type: 'error', 
                        timeout: 2000,
                        buttons: [
                            Noty.button('Go to cart', 'btn btn-success btn-sm', function () {
                                alert('sad')
                            }),
                        ]
                    }).show();
                    
                })
                .fail(function (err) {
                    
                })
                .always(function () {
                    $this.removeAttr('disabled').text('Cart');
                });
        })
    });
</script>
@stack('section-js')
@endpush