@extends('admin.layout')

@section('admin-title', 'Menu Categories')

@section('admin-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                 @if($data->id)
                   Update menu category: {{ $data->name }}
                @else
                    Create new menu category
                @endif
            </h4>
        </div>
        @if($data->id)
            {!! Form::model($data, ['url' => route('menu-categories.update', ['id' => $data->id]), 'method' => 'PATCH']) !!}
        @else
            {!! Form::open(['url' => route('menu-categories.store'), 'method' => 'POST']) !!}
        @endif
                
        <div class="panel-body">
            {!! Form::bsText('name', 'Name') !!}
            {!! Form::bsText('description', 'Description') !!}
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            {!! link_to_route('menu-categories.index', 'Back', null, ['class' => 'pull-right btn btn-default']) !!}
        </div>
         {!! Form::close() !!}
    </div>
@endsection