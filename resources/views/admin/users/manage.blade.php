@extends('admin.layout')

@section('admin-title', 'Users')

@section('admin-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                Update user: {{ $data->fullname() }}
            </h4>
        </div>
        {!! Form::model($data, ['url' => route('users.update', ['id' => $data->id]), 'method' => 'PATCH']) !!}
        <div class="panel-body">
                <div class="bs-callout bs-callout-info">
                    <i class="fa fa-info-circle"></i> Leave password field blank to leave it unchanged.
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::bsSelect('role', 'Account Type', ['' => '', 'OWNER' => 'Restaurant Owner', 'USER' => 'Regular User'], $data->role) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::bsText('username', 'Username') !!}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::bsText('firstname', 'First Name') !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::bsText('lastname', 'Last Name') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::bsText('contact_number', 'Contact Number') !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::bsText('email', 'Email Address') !!}
                    </div>
                </div>
                
                <div class="row">
                    
                    <div class="col-sm-6">
                        {!! Form::bsPassword('password', 'Password') !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Form::bsPassword('password_confirmation', 'Password Confirmation') !!}
                    </div>
                </div>
                    
                
            
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            {!! link_to_route('users.index', 'Back', request()->only(['account_type', 'name_keyword']), ['class' => 'pull-right btn btn-default']) !!}
        </div>
         {!! Form::close() !!}
    </div>
@endsection