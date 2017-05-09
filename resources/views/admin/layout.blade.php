@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')
<div class="nav-side-menu">
    <div class="brand">{{ config('app.name') }} | ADMIN</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-fw fa-circle fa-lg"></i> Users
                </a>
            </li>
            <li>
                <a href="{{ route('restaurants.index') }}">
                    <i class="fa fa-fw fa-circle fa-lg"></i> Restaurants
                </a>
            </li>
             
            <li>
                <a href="{{ route('categories.index') }}">
                    <i class="fa fa-fw fa-circle fa-lg"></i> Restaurant Categories
                </a>
            </li>
            <li>
                <a href="{{ route('menu-categories.index') }}">
                    <i class="fa fa-fw fa-circle fa-lg"></i> Menu Categories
                </a>
            </li>
            <li>
                <a href="{{ route('restaurant-ads.index') }}">
                    <i class="fa fa-fw fa-circle fa-lg"></i> Restaurant Advertisements
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="javascript:document.getElementById('signout').submit()">
                   
                    <i class="fa fa-fw fa-circle fa-lg"></i> 
                    {!! Form::open(['url' => url('/logout'), 'method' => 'POST', 'id' => 'signout']) !!}
                         Logout
                    {!! Form::close() !!}
                    </a>
                    
                </a>
            </li>
            <!--
            <li data-toggle="collapse" data-target="#new" class="collapsed">
                <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="new">
                <li>New New 1</li>
                <li>New New 2</li>
                <li>New New 3</li>
            </ul>
            -->
            
        </ul>
    </div>
</div>
<div class="container" id="main">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h3>@yield('admin-title', 'Page title goes here')</h3>
            </div>
            @yield('admin-content')
        </div>
    </div>
</div>
@endsection 

@push('scripts')
@endpush