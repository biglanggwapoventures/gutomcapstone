@extends('restaurant.layout', compact('restaurant'))

@push('section-styles')

@endpush
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@section('section')
    @if($cart->isEmpty())
        <div class="bs-callout bs-callout-danger" style="background:#fff">
            <i class="fa fa-info-circle"></i> Cart is empty for this restaurant.
        </div>
    @else
        <div class="row">
            <div class="col-md-4 col-sm-5">
                <div class="box">
                    <div class="box-content" style="padding:0">
                        <h1 class="tag-title">Order Review</h1>
                        <hr />
                        {!! Form::open(['url' => route('orders.store'), 'method' => 'POST']) !!}
                            {!! Form::hidden('restaurant_id', $restaurant->id) !!}
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::bsSelect('order_type', 'Order Type', ['' => '', 'PICK_UP' => 'PICK UP', 'DINE_IN' => 'DINE IN']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::bsSelect('payment_type', 'Payment Type', ['' => '', 'CASH' => 'CASH', 'CREDIT_CARD' => 'CREDIT CARD']) !!}
                                </div>
                            </div>
                            {!! Form::bsText('name', 'Name', Auth::user()->fullname()) !!}
                            {!! Form::bsText('contact_number', 'Contact Number', Auth::user()->contact_number) !!}
                            <div class="row">
                                <div class="col-sm-7">
                                    {!! Form::bsDate('order_date', 'Date') !!}
                                </div>
                                <div class="col-sm-5">
                                {!! Form::bsText('order_time', 'Time', null, ['class' => 'form-control timepicker']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::bsText('guest_count', 'Guest Count', null, ['class' => 'form-control disabled-pickup']) !!}
                                </div>
                                <!--<div class="col-sm-6">
                                {!! Form::bsText('cook_time', 'Time to cook', null, ['class' => 'form-control timepicker disabled-pickup']) !!}
                                </div>-->
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">Checkout</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-7">
                
                    <div class="box">
                        <div class="box-content" style="padding:0">
                            <h1>&nbsp;</h1>
                            
                            <div class="shopping-cart">

                                    <div class="column-labels">
                                        <label class="product-image">Image</label>
                                        <label class="product-details">Product</label>
                                        <label class="product-price">Price</label>
                                        <label class="product-quantity">Quantity</label>
                                        <label class="product-removal">Remove</label>
                                        <label class="product-line-price">Total</label>
                                    </div>


                                    

                                        @foreach($cart AS $c)
                                            <div class="product" data-pk="{{ $c->id }}" data-menu-id="{{ $c->menu_id }}">
                                                <div class="product-image">
                                                    <img src="{{ $c->item->photo }}">
                                                </div>
                                                <div class="product-details">
                                                    <div class="product-title">{{ $c->item->name }}</div>
                                                        <p class="product-description">{{ $c->item->description }}</p>
                                                    </div>
                                                <div class="product-price" data-value="{{ $c->item->price }}">{{ $c->item->price }}</div>
                                                <div class="product-quantity">
                                                    {!! Form::number('', $c->quantity, ['class' => 'product-quantity-input', 'min' => 1, 'step' => 1]) !!}
                                                </div>
                                                <div class="product-removal">
                                                    <button class="btn btn-success btn-xs update-product" type="button">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-xs remove-product" type="button">
                                                        <i class="fa fa-times" type="button"></i>
                                                    </button>
                                                </div>
                                                <div class="product-line-price"></div>
                                        </div>
                                        @endforeach

                                        <div class="totals">
                                            <div class="totals-item totals-item-total">
                                            <label>Total</label>
                                            <div class="totals-value" id="cart-total"></div>
                                            </div>
                                        </div>
                                    
                                

                            </div>
                            
                        
                        </div>
                    </div>
                
            </div>
        </div>
     @endif
@endsection

@push('section-js')
<script type="text/javascript" src="{{ asset('plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.timepicker').timepicker({
            disableFocus: true,
            defaultTime: false
        });

        $('select[name=order_type]').change(function(){
            var type = $(this).val();
            if(!type.length || type === 'PICK_UP'){
                $('.disabled-pickup').attr('disabled', 'disabled');
                return;
            }
            $('.disabled-pickup').removeAttr('disabled');
        }).trigger('change')

        function cartTotal() {
            var total = 0;
            $('.product').each(function(){
                var el = $(this),
                    qty = parseInt(el.find('.product-quantity-input').val()),
                    price = parseFloat(el.find('.product-price').data('value')),
                    amount = (qty * price)
                
                total+=amount;


                el.find('.product-line-price').text(amount.toFixed(2));
            })
            $('#cart-total').text(total.toFixed(2));
        }
        
        cartTotal();

        $('.update-product').click(function(){

            var $this = $(this),
                spinner = '<i class="fa fa-spin fa-spinner"></i>',  
                url = '{{ route("cart.update", ["id" => "__ID__"]) }}',
                id = $this.closest('.product').data('pk'),
                menuId = $this.closest('.product').data('menu-id'),
                quantityField =  $this.closest('.product').find('.product-quantity-input')
                quantity = quantityField.val();

            $this.attr('disabled', 'disabled').html(spinner)

            $.ajax({
                method: 'PATCH',
                url: url.replace('__ID__', id),
                data: {
                    menu_id: menuId,
                    quantity: quantity
                },
                success: function (res) {
                    if(!res.result) return;
                    cartTotal();
                    new Noty({ 
                        layout: 'bottomRight',
                        text: 'Update success!', 
                        type: 'error', 
                        timeout: 2000,
                    }).show();
                    
                },
                error: function() {
                     new Noty({ 
                        layout: 'bottomRight',
                        text: 'An internal error has occured. Please try again!', 
                        type: 'error', 
                        timeout: 2000,
                    }).show();
                },
                complete: function() {
                     $this.removeAttr('disabled').html('<i class="fa fa-check"></i>');
                }
            })
        })

        $('.remove-product').click(function(){
            if(!confirm('Are you sure you want to remove this order?')) return;
            var $this = $(this),
                spinner = '<i class="fa fa-spin fa-spinner"></i>',  
                url = '{{ route("cart.destroy", ["id" => "__ID__"]) }}',
                id = $this.closest('.product').data('pk'),
                menuId = $this.closest('.product').data('menu-id');

            $this.attr('disabled', 'disabled').html(spinner)

            $.ajax({
                method: 'DELETE',
                url: url.replace('__ID__', id),
                data: {
                    menu_id: menuId,
                },
                success: function (res) {
                    if(!res.result) return;
                    window.location.reload();
                },
                error: function() {
                    new Noty({ 
                        layout: 'bottomRight',
                        text: 'An internal error has occured. Please try again!', 
                        type: 'error', 
                        timeout: 2000,
                    }).show();
                },
                complete: function() {
                     $this.removeAttr('disabled').html('<i class="fa fa-times"></i>');
                }
            })
        })

    })
</script>
@endpush
