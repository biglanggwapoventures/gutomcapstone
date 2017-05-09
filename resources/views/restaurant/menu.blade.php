@extends('restaurant.layout', compact('restaurant'))


@section('section')
@if($restaurant->menu->isEmpty())
    <div class="alert alert-warning text-center">
        No menu recorded
    </div>
@else
    <div class="row" style="margin-top:10px;">
        <div class="col-sm-3">
            <div class="box" style="padding:10px;">
                <div class="box-content" style="padding:0">
                    <h4 class="text-center text-info">Menu Categories</h4>
                    <ul class="nav nav-pills nav-stacked"  style="border-top:1px solid #e7e7e7">
                        @foreach($categories AS $id => $name)
                            <li role="presentation" class="{{ request()->input('category') == $id ? 'active' : '' }}">
                                <a href="{{ route('restaurant.menu', ['id' => $restaurant->id,  'category' => $id]) }}">{{ $name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            @foreach($restaurant->menu->chunk(ceil($restaurant->menu->count() / 2)) AS $group)
                    <div class="col-md-6" >
                    @foreach($group AS $m)
                        <div class="row">
                            <div class="col-md-12" style="margin-top:10px;">
                                <div class="food-card">
                                    <div style="height:150px;background:url({{ $m->photo }}) center center no-repeat;background-size:cover;border-radius:4px">
                                        
                                    </div>
                                    <div class="details">
                                        <h4 style="margin:0px">{{ $m->name }}<small class="pull-right label label-danger">Php {{ number_format($m->price, 2) }}</small></h4>
                                        <p style="color:#89959B;border-bottom:1px dashed #e7e7e7;padding-bottom:5px;text-transform:uppercase">
                                            {{ implode(', ', $m->categoriesFlatArray()) }}
                                        </p>
                                        <div data-hidden="expand">
                                            <table style="width:100%;font-size:90%;margin-bottom:10px">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:30%;color: #89959B;">DESCRIPTION</td>
                                                        <td>{{ $m->description }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color: #89959B;">PREPARATION</td>
                                                        <td>{{ $m->preparation }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if(Auth::check())
                                            <div class="row">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <div class="input-group" style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px dashed #e7e7e7;">
                                                        <input type="number" step="1" min="1" class="form-control input-sm item-quantity">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success btn-sm btn-cart" data-pk="{{ $m->id }}"><i class="fa fa-shopping-cart fa-fw"></i> Cart</button>
                                                        </span>
                                                    </div><!-- /input-group -->
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

@push('section-js')
    <script type="text/javascript"> 
        $(document).ready(function(){
            $('.food-card').hover(function(){
                $(this).find('[data-hidden]').slideToggle();
            });
        })
    </script>
@endpush