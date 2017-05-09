@extends('admin.layout')

@section('admin-title', 'Restaurants')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
    

@section('admin-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                Update restaurant: {{ $data->name }}
            </h4>
        </div>
        {!! Form::model($data, ['url' => route('restaurants.update', ['id' => $data->id]), 'method' => 'PATCH']) !!}
        <div class="panel-body">
            {!! Form::bsText('name', 'Restaurant Name') !!}
            {!! Form::bsSelect('categories[]', 'Category', $categories, $data->category_ids, ['class' => 'form-control select2' , 'multiple' => 'true']) !!}
            {!! Form::bsTextarea('description', 'Description') !!}
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::bsText('address', 'Address') !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::bsText('contact_number', 'Contact Number') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::bsSelect('status', 'Set status to:', ['p' =>'Pending', 'a' => 'Approved'], $data->status) !!}
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            {!! link_to_route('restaurants.index', 'Back', request()->only(['status', 'name_keyword']), ['class' => 'pull-right btn btn-default']) !!}
        </div>
         {!! Form::close() !!}
    </div>
@endsection


@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>
@endpush