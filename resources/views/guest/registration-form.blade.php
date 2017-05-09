@extends('layouts.app')

@section('title', 'Sign up at Gutom')

@section('content')
@include('partials.navbar')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            {!! Form::open(['url' => url('/register'), 'method' => 'POST']) !!}
                <fieldset>
                    @if(count($errors))
                        <div class="alert alert-danger">
                            Please review the following errors!
                        </div>
                    @endif
                    <legend>Sign up for an account here!</legend>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::bsSelect('role', 'Account Type', ['' => '', 'OWNER' => 'Restaurant Owner', 'USER' => 'Regular User']) !!}
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
                    <button type="submit" class="btn btn-success">Create my account</button>
                </fieldset>
            {!! Form::close() !!}
            <hr>
            {!! link_to('/login', 'I already have an account', ['class' => 'pull-right']) !!}
        </div>
    </div>
</div>

@endsection