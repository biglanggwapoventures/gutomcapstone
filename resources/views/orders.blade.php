@extends('layouts.app')

@section('title', 'Gutom - Cebu Restaurant Portal')

@section('content')

    @include('partials.navbar')

    <div class="container-fluid" style="margin-top:-22px;">
        @include('partials.search')
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1" >
                 <h3 style="font-weight:bold">My Orders</h3>
            </div>
        </div>
        <div class="row" style="margin-top:10px;">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="box" style="padding:10px;margin-top:0">
                            <div class="box-content" style="padding:0">
                                <ul class="nav nav-pills nav-stacked">
                                        <li role="presentation" class="{{ !request()->has('status') || request()->input('status') === 'PENDING' ? 'active' : '' }}">
                                            <a href="{{ route('orders.index', ['status' => 'PENDING']) }}">Pending</a>
                                        </li>
                                        <li role="presentation" class="{{ request()->input('status') === 'APPROVED' ? 'active' : '' }}">
                                            <a href="{{ route('orders.index', ['status' => 'APPROVED']) }}">
                                                Approved
                                                @if($approvedUnreadCount)
                                                    <span class="badge">{{ $approvedUnreadCount }}</span>
                                                @endif
                                            </a>
                                        </li>
                                        <li role="presentation" class="{{ request()->input('status') === 'CANCELLED' ? 'active' : '' }}">
                                            <a href="{{ route('orders.index', ['status' => 'CANCELLED']) }}">
                                                Cancelled
                                                @if($cancelledApprovedCount)
                                                    <span class="badge">{{ $cancelledApprovedCount }}</span>
                                                @endif
                                                
                                            </a>
                                        </li>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="box" style="padding:20px;margin-top:0">
                            <div class="box-content" style="padding:0">

                                <table class="table table-condensed table-hover ">
                                    <thead>
                                        <tr class="danger">
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Restaurant</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($items AS $i)
                                            <tr data-pk="{{ $i->id }}">
                                                <td>{{ $i->id }}</td>
                                                <td>{{ date_create("{$i->order_date} {$i->order_time}")->format('F d, Y \@ h:i A') }}</td>
                                                <td>{{ $i->restaurant->name }}</td>
                                                <td>{{ $i->getReadableType() }} </td>
                                                <td>{{ $i->getTotal(true) }}</td>
                                                <td>
                                                    <a data-toggle="modal" data-target="#order-{{ $i->id }}" class="btn btn-danger btn-sm">View</a>
                                                    <div class="modal fade" id="order-{{ $i->id }}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    
                                                                    <div class="shopping-cart" style="margin-top:0;padding:5px">

                                                                        <div class="column-labels">
                                                                            <label class="product-image">Image</label>
                                                                            <label class="product-details">Product</label>
                                                                            <label class="product-price">Price</label>
                                                                            <label class="product-quantity">Quantity</label>
                                                                            <label class="product-removal">Remove</label>
                                                                            <label class="product-line-price">Total</label>
                                                                        </div>
                                                                        @foreach($i->items AS $c)
                                                                            <div class="product" data-pk="{{ $c->id }}" data-menu-id="{{ $c->menu_id }}">
                                                                                <div class="product-image">
                                                                                    <img src="{{ $c->details->photo }}">
                                                                                </div>
                                                                                <div class="product-details">
                                                                                    <div class="product-title">{{ $c->details->name }}</div>
                                                                                        <p class="product-description">{{ $c->details->description }}</p>
                                                                                    </div>
                                                                                <div class="product-price">{{ $c->formattedPrice() }}</div>
                                                                                <div class="product-quantity">
                                                                                    @if($i->isPending())
                                                                                        {!! Form::number('', $c->quantity, ['class' => 'product-quantity-input', 'min' => 1, 'step' => 1]) !!}
                                                                                     @else
                                                                                        <p>{{ number_format($c->quantity, 2)  }}</p>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="product-removal">
                                                                                    @if($i->isPending())
                                                                                        <button class="btn btn-success btn-xs update-product" type="button">
                                                                                            <i class="fa fa-check"></i>
                                                                                        </button>
                                                                                        <button class="btn btn-danger btn-xs remove-product" type="button">
                                                                                            <i class="fa fa-times" type="button"></i>
                                                                                        </button>
                                                                                    @else
                                                                                        {!! !$c->available ? '<span class="text-danger text-uppercase">not available</span>' : '&nbsp;' !!}
                                                                                    @endif
                                                                                </div>
                                                                                <div class="product-line-price">
                                                                                    {{ $c->getAmount(true) }}
                                                                                </div>
                                                                        </div>
                                                                        @endforeach

                                                                        <div class="totals">
                                                                            <div class="totals-item totals-item-total">
                                                                            <label>Total</label>
                                                                            <div class="totals-value" id="cart-total">{{ $i->getTotal(true) }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if($i->isApproved())
                                                                        <div class="bs-callout bs-callout-danger">
                                                                            <h4>This order is accepted / approved! <i class="fa fa-check"></i> </h4>
                                                                            <p>{!! $i->remarks ?: '<em>No remarks</em>' !!}</p>
                                                                        </div>
                                                                    @elseif($i->isCancelled())
                                                                        <div class="bs-callout bs-callout-warning">
                                                                            <h4>This order is cancelled / rejected! <i class="fa fa-times"></i> </h4>
                                                                            <p>{!! $i->remarks ?: '<em>No remarks</em>' !!}</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="modal-footer clearfix">
                                                                    @if($i->isPending())
                                                                        {!! Form::open(['url' => url('cancel-order', ['orderId' => $i->id]), 'method' => 'PATCH', 'style' => "display:inline-block", 'class' => "pull-left", 'onsubmit' => 'javascript:return confirm(\'Are you sure you want to cancel this order?\')']) !!}
                                                                            <button type="submit" class="btn btn-danger">Cancel this order</button>
                                                                        {!! Form::close() !!}
                                                                    @endif
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No items to show</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
        $(document).ready(function() {
            $('.update-product').click(function(){

                var $this = $(this),
                    spinner = '<i class="fa fa-spin fa-spinner"></i>',  
                    url = '{{ route("orders.update", ["id" => "__ID__"]) }}',
                    id = $this.closest('tr').data('pk'),
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
                        new Noty({ 
                            layout: 'bottomRight',
                            text: 'Update success!', 
                            type: 'error', 
                            timeout: 2000,
                        }).show();
                        
                    },
                    error: function() {

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
                    url = '{{ route("orders.destroy", ["id" => "__ID__"]) }}',
                    id = $this.closest('tr').data('pk'),
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