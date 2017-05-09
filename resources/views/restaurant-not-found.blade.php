@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
    
@section('content')
    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body ">
                        <p class="text-center text-info "><i class="fa fa-cutlery fa-2x"></i></p>
                        <p class="lead text-center text-info "> It seems like you have not created any restaurant yet. <br> Let's get you started!</p> 
                       {!! Form::open(['url' => url('/my-restaurant/register'), 'method' =>'POST', 'enctype' => 'multipart/form-data']) !!}
                            {!! Form::bsText('name', 'Desired Restaurant Name') !!}
                            {!! Form::bsSelect('categories[]', 'Category', $categories,  null, ['class' => 'form-control', 'multiple' => 'true']) !!}
                            {!! Form::bsTextarea('description', 'Description') !!}
                            {!! Form::bsText('address', 'Address') !!}
                            {!! Form::bsText('contact_number', 'Contact Number') !!}
                            {!! Form::bsFile('logo', 'Logo') !!}
                            <hr>
                            <button type="submit" class="btn btn-success btn-block">Create Restaurant</button>
                       {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();
    })
</script>
@endpush