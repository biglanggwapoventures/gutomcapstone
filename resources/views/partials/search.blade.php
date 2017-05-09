 <div class="row" style="background:url({{asset('images/food-cover.jpg')}}) no-repeat;color:#fff;background-size:cover">
    <div class="col-md-12">
        <div class="text-center" >
            <h3 style="margin-bottom:0">
                <span class="fa-stack fa-lg">
                    <i class="fa fa-square-o fa-stack-2x"></i>
                    <i class="fa fa-cutlery fa-stack-1x"></i>
                </span>
            </h3>
            <h1 style="margin-top:0;margin-bottom:0;display:inline">GUTOM</h1><p class="lead" style="display:inline"> Cebu Restaurant Portal</p>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    {!! Form::open(['url' => url('/'), 'method' => 'GET', 'style' => 'margin-top:10px']) !!}
                        <div class="row">
                            <div class="col-sm-3" style="padding-right:5px">
                                <div class="form-group">
                                    {!! Form::select('q', ['food' => 'Food', 'restaurant-name' => 'Restaurant Name', 'restaurant-type' => 'Restaurant Type', 'location' => 'Location'], request()->input('q'), ['class' => 'form-control', 'placeholder' => '']) !!}
                                </div>
                            </div>
                            <div class="col-sm-9" style="padding-left:5px">
                                <div class="form-group">
                                    <div class="input-group">
                                        {!! Form::text('v', request()->input('v'), ['class' =>'form-control']) !!}
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger " type="submit">Search</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            
        </div>
    </div>
</div>