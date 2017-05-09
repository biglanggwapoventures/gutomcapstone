@extends('layouts.app')

@section('title', 'Login at Gutom')

@section('content')
@include('partials.navbar')
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            {!! Form::open(['url' => url('/login'), 'method' => 'POST']) !!}
                <fieldset>
                    @if(count($errors) || session('loginError'))
                        <div class="alert alert-danger">{{ session('loginError') ? 'You entered an invalid username or password' :  'Please review the following errors!' }}
                        </div>
                    @endif

                    <legend>Login at Gutom!</legend>
                    {!! Form::bsText('username', 'Username') !!}
                    {!! Form::bsPassword('password', 'Password') !!}
                    <button type="submit" class="btn btn-success">Login</button>
                </fieldset>
            {!! Form::close() !!}
            <hr>
            {!! link_to('/register', 'I do not have an account', ['class' => 'pull-right']) !!}
        </div>
    </div>
</div>

@endsection