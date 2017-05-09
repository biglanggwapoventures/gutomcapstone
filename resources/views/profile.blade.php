@extends('layouts.app')
    
@section('content')
    @include('partials.navbar')
    <div class="container">
        <div class="row">
            <div class="col-md-12"><h3 style="font-weight:bold;margin-top:0">Profile</h3></div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="box">
                    <div class="box-content">
                        <!--<div class="row">-->
                            <!--<div class="col-md-4 col-md-offset-4  col-xs-6 col-xs-offset-3">-->
                                <img src="{{ Auth::user()->displayPhoto() }}" alt="{{ Auth::user()->fullname() }}" class="img-responsive img-circle img-thumbnail center-block">
                            <!--</div>-->
                        <!--</div>-->
                        <h2 class="text-center">{{ Auth::user()->fullname() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="box">
                    <div class="box-content">
                        {!! Form::model($user, ['url' => url('profile'), 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
                            {!! Form::bsFile('photo', 'Display Photo') !!}
                            {!! Form::bsText('email', 'Email Address') !!}
                            {!! Form::bsText('contact_number', 'Contact Number') !!}
                            {!! Form::bsPassword('password', 'Password') !!}
                            {!! Form::bsPassword('password_confirmation', 'Password Confirmation') !!}
                            <button type="submit" class="btn btn-danger">Save changes</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if(session('profile.update.status'))
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                new Noty({ 
                    layout: 'bottomRight',
                    text: 'Your profile has been successfully updated!', 
                    type: 'error', 
                    timeout: 2000,
                }).show();
            })
        </script>
    @endpush
@endif