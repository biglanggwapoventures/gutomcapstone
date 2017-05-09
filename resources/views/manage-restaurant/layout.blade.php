@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manage-restaurant.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('content')
    @include('partials.navbar')

    <div class="container">
        @if(!$restaurant->isApproved())
        <div class="row">
            <div class="col-sm-12">
                <div class="bs-callout bs-callout-danger text-danger" style="background:#fff ">
                    <strong></strong><i class="fa fa-info-circle"></i></strong> Your restaurant is not yet approved. This means that your restaurant is not yet eligible to appear in search results. However, you are free to update your restaurant information and preview it <a href="{{ route('restaurant.overview', ['id' => $restaurant->id]) }}">here</a>.
                </div>
            </div>
        </div>
        @endif
        <div class="row profile">
            <div class="col-md-3 col-sm-4 col-xs-5">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <a href="{{ $restaurant->logo }}" data-fancybox data-caption="My caption">
                            <img src="{{ $restaurant->logo }}" class="img-thumbnail center-block" alt="">
                        </a>

                        
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            {{ $restaurant->name }}
                        </div>
                        <!--<div class="profile-usertitle-job">
                            
                        </div>-->
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons hidden">
                        <button type="button" class="btn btn-success btn-sm">Follow</button>
                        <button type="button" class="btn btn-danger btn-sm">Message</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="{{ $nav === 'overview' ? 'active' : ''}}">
                                <a href="{{ url('/my-restaurant') }}">
                                <i class="fa fa-user-circle"></i>
                                Overview </a>
                            </li>
                            <li class="{{ $nav === 'ophours' ? 'active' : ''}}">
                                <a href="{{ url('/my-restaurant/operating-hours') }}">
                                <i class="fa fa-clock-o"></i>
                                Operating Hours </a>
                            </li>
                            <li class="{{ $nav === 'menu' ? 'active' : ''}}">
                                <a href="{{ route('menu.index') }}">
                                <i class="fa fa-book"></i>
                                Menu </a>
                            </li>
                            <li class="{{ $nav === 'blog' ? 'active' : ''}}">
                                <a href="{{ route('blog.index') }}">
                                <i class="fa fa-pencil"></i>
                                Blog </a>
                            </li>
                            <li class="{{ $nav === 'promos' ? 'active' : ''}}">
                                <a href="{{ route('promos.index') }}">
                                <i class="fa fa-bullhorn"></i>
                                Promos </a>
                            </li>
                            <li class="{{ $nav === 'advertisement' ? 'active' : ''}}">
                                <a href="{{ route('advertisements.index') }}">
                                <i class="fa fa-bookmark-o"></i>
                                Advertisements </a>
                            </li>
                            <li class="{{ $nav === 'photos' ? 'active' : ''}}">
                                 <a href="{{ route('photos.index') }}">
                                <i class="fa fa-image"></i>
                                Photos </a>
                            </li>
                            <li class="{{ $nav === 'orders' ? 'active' : ''}}">
                                <a href="{{ route('food-orders.index') }}">
                                <i class="fa fa-folder-open"></i>
                                @php
                                    $count = $restaurant->getPendingOrdersCount()
                                @endphp
                                Orders 
                                @if($count)
                                    <span class="badge">{{ $count }}</span>
                                @endif
                                </a>
                            </li>
                            <li class="{{ $nav === 'order-status' ? 'active' : ''}}">
                                <a href="{{ route('reports.order-status') }}">
                                <i class="fa fa-pie-chart"></i>
                                Status Report </a>
                            </li>
                            <li class="{{ $nav === 'top-sellers' ? 'active' : ''}}">
                                <a href="{{ route('reports.top-sellers') }}">
                                <i class="fa fa-pie-chart"></i>
                                Top Sellers </a>
                            </li>
                            <li class="{{ $nav === 'daily-sales' ? 'active' : ''}}">
                               <a href="{{ route('reports.daily-sales') }}">
                                <i class="fa fa-pie-chart"></i>
                                Daily Sales  </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-7">
                <div class="profile-content">
                    @yield('form')
                </div>
            </div>
        </div>
    </div>

@endsection