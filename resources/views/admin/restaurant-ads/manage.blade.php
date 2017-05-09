@extends('admin.layout')

@section('admin-title', 'Restaurant Advertisements')

@section('admin-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                Update restaurant ad: {{ $data->title }}
            </h4>
        </div>
        {!! Form::model($data, ['url' => route('restaurant-ads.update', ['id' => $data->id]), 'method' => 'PATCH']) !!}
        <div class="panel-body">
             <div class="row">
                 <div class="col-sm-8">
                     <div class="row">
                        <div class="col-sm-4">
                            {!! Form::bsText('title', 'Name') !!}
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Duration</label>
                                <p class="form-control-static">
                                    {{ date_create($data->start_date)->format('F d, Y') }} - {{ date_create($data->end_date)->format('F d, Y')  }}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Created by:</label>
                                <p class="form-control-static">
                                    {{ $data->restaurant->name  }}
                                </p>
                            </div>
                        </div>
                    </div>
                    {!! Form::bsTextarea('description', 'Description') !!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::bsSelect('status', 'Set Status', ['APPROVED' => 'Approved', 'REJECTED' => 'Rejected', 'PENDING' => ''], $data->status) !!}
                        </div>
                    </div>
                 </div>
                 <div class="col-sm-4">
                      <img src="{{ $data->photo }}" alt="" class="img-thumbnail img-responsive center-block">
                 </div>
            </div>
           
           
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            {!! link_to_route('restaurant-ads.index', 'Back', ['status' => $data->status], ['class' => 'pull-right btn btn-default']) !!}
        </div>
         {!! Form::close() !!}
    </div>
@endsection