@extends('manage-restaurant.layout', ['nav' => 'orders'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-folder-open fa-fw"></i> Orders</h4>
			</div>
			
			{!! Form::open(['url' => route('food-orders.index'), 'method' => 'GET', 'class' => 'form-inline']) !!}
				<div class="form-group">
                    <labe>Filter by order type:</label>
                    {!! Form::select('status', ['PENDING' => 'Pending Orders', 'APPROVED' => 'Approved Orders', 'CANCELLED' => 'Cancelled Orders'], request()->input('status'), ['class' => 'form-control']) !!}
                    <button type="submit" class="btn btn-danger">Go</button>
                </div>
			{!! Form::close() !!}
            <table class="table table-condensed table-hover" style="margin-top:10px;">
                <thead>
                    <tr class="danger">
                        <th>#</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restaurant->orders AS $i)
                        <tr>
                            <td>{{ $i->id }}</td>
                            <td>{{ date_create("{$i->order_date} {$i->order_time}")->format('F d, Y \@ h:i A') }}</td>
                            <td>{{ $i->customer->fullname() }}</td>
                            <td>{{ $i->getReadableType() }}</td>
                            <td>{{ $i->getTotal(true) }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#order-{{ $i->id }}" class="btn btn-danger btn-sm">View</a>
                                <div class="modal fade" id="order-{{ $i->id }}" tabindex="-1" role="dialog">
                                    {!! Form::open(['url' => route('food-orders.update', ['id' => $i->id]), 'method' => 'PATCH', 'class' => 'ajax']) !!}
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="shopping-cart" style="margin-top:0;padding:5px">
                                                                <div class="column-labels">
                                                                    <label class="product-image">Image</label>
                                                                    <label class="product-details">Product</label>
                                                                    <label class="product-price">Price</label>
                                                                    <label class="product-quantity">Quantity</label>
                                                                    <label class="product-removal">Remove</label>
                                                                    <label class="product-line-price">Total</label>
                                                                </div>
                                                                @foreach($i->items AS $key => $c)
                                                                    <div class="product">
                                                                        <div class="product-image">
                                                                            <img src="{{ $c->details->photo }}">
                                                                        </div>
                                                                        <div class="product-details">
                                                                            <div class="product-title">{{ $c->details->name }}</div>
                                                                                <p class="product-description">{{ $c->details->descriptionExcerpt() }}</p>
                                                                            </div>
                                                                        <div class="product-price">{{ $c->formattedPrice() }}</div>
                                                                        <div class="product-quantity">
                                                                            {{ $c->quantity }}
                                                                        </div>
                                                                        <div class="product-removal">   
                                                                            @if($i->isPending())
                                                                                {!! Form::hidden("available[{$key}][order_line_id]", $c->id) !!}
                                                                                {!! Form::select("available[{$key}][available]", ['1' => 'AVAILABLE', '0' => 'UNAVAILABLE'], $c->available, ['class' => 'form-control input-sm change-availability']) !!}
                                                                            @else
                                                                                {!! !$c->available ? '<span class="text-danger text-uppercase">not available</span>' : '&nbsp;' !!}
                                                                            @endif
                                                                        </div>
                                                                        <div class="product-line-price" data-value="{{ $c->getAmount() }}">
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
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">Order Details</h4>
                                                                </div>
                                                                <table class="table table-hover table-condensed">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Order #</td>
                                                                                <td>{{ $i->id }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Type</td>
                                                                                <td>{{ $i->getReadableType() }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Customer</td>
                                                                                <td>{{ $i->customer->fullname() }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Contact No.</td>
                                                                                <td>{{ $i->customer->contact_number }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Date</td>
                                                                            <td>{{ date_create($i->order_date)->format('F d, Y') }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Time</td>
                                                                            <td>{{ date_create($i->order_time)->format('g:i A') }}</td>
                                                                        </tr>
                                                                        @if($i->isDineIn())
                                                                            <tr>
                                                                                <td>Guest Count</td>
                                                                                <td>{{ $i->guest_count }}</td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">Order Actions</h4>
                                                                </div>
                                                                <div class="panel-body">
                                                                    @if($i->isPending())
                                                                        {!! Form::bsSelect('order_status', 'Set Status', ['' => '', 'APPROVED' => 'Approve', 'CANCELLED' => 'Cancel/Reject']) !!}
                                                                        {!! Form::bsTextarea('remarks', 'Order Remarks') !!}
                                                                        <button type="submit" class="btn btn-danger">Submit</button>
                                                                    @else
                                                                        <div class="form-group">
                                                                            <label for="">Remarks</label>
                                                                            <p class="form-control-static">{{ $i->remarks }}</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    @if($i->isPending())
                                                    
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No items to show</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
		</div>
	</div>
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function () {

        $('.change-availability').change(function(){
            var total = 0;
            $('.product').each(function () {
                if(parseInt($(this).find('.change-availability').val())){
                    total += parseFloat($(this).find('.product-line-price').data('value'));
                }
            })
            $('#cart-total').text(total.toFixed(2));
        })
        $('.ajax').submit(function (e) {
            e.preventDefault();

            var $this = $(this),    
                data = $this.serialize(),
                btn = $(this).find('[type=submit]');

            btn.attr('disabled', 'disabled');

            $.ajax({
                url: $this.attr('action'),
                method: 'PATCH',
                data: data,
                success: function (res) {
                    if(res.result){
                        window.location.href = res.next;
                    }else{
                        new Noty({ 
                            layout: 'bottomRight',
                            text: 'An unexpected error has occured. Please refresh the page', 
                            type: 'error', 
                            timeout: 2000,
                        }).show();
                    }
                },
                fail: function () {
                     new Noty({ 
                        layout: 'bottomRight',
                        text: 'An internal server error has occured. Please try again later', 
                        type: 'error', 
                        timeout: 2000,
                    }).show();
                },
                always: function () {
                    btn.removeAttr('disabled')
                }
            })
        }) 
    });
</script>
@endpush