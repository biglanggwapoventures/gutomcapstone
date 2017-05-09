<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if(Auth::check() && Auth::user()->isOwner() && Auth::user()->hasRestaurant())
      <a class="navbar-brand text-info"  href="{{ route('restaurant.overview', ['id' => Auth::user()->restaurant->id]) }}"><i class="fa fa-cutlery"></i> {{ config('app.name', 'APP_NAME') }}</a>
      @else
      <a class="navbar-brand text-info"  href="{{ url('/') }}"><i class="fa fa-cutlery"></i> {{ config('app.name', 'APP_NAME') }}</a>
      @endif
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      @if(Auth::check() && Auth::user()->role === 'OWNER')
        @if(!Auth::user()->hasRestaurant())
        <form class="navbar-form navbar-left">
          <a class="btn btn-default" href="{{ url('my-restaurant') }}">Start creating your restaurant profile!</a>
        </form>
        @else
          <ul class="nav navbar-nav">
            @php
                $ordersCount = Auth::user()->restaurant->getPendingOrdersCount()
            @endphp
            <li>
                <a href="{{ url('/my-restaurant') }}">
                  My Restaurant
                  @if($ordersCount)
                      <span class="badge">{{ $ordersCount }}</span>
                  @endif
                
              </a>
          </li>
         </ul>
        @endif
      @endif

      @if(Auth::check() && Auth::user()->role !== 'OWNER')
       <ul class="nav navbar-nav">
        <li>
          <a href="{{ route('orders.index') }}">
            My Orders
            @php
              $unreadCount =   Auth::user()->getOrdersNotificationCount(true)
            @endphp
            @if($unreadCount)
                <span class="badge">{{ $unreadCount }}</span>
            @endif
            
          </a>
        </li>
        </ul>
      @endif
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->fullname() }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ url('/profile') }}">My Profile</a></li>
              
              
              <li role="separator" class="divider"></li>
              <li>
                {!! Form::open(['url' => url('/logout'), 'method' => 'POST', 'id' => 'signout']) !!}
                {!! Form::close() !!}
                <a href="javascript:void(0)" onclick="javascript:document.getElementById('signout').submit()">Logout</a>
              </li>
            </ul>
          </li>
        @else
          <li><a href="{{ url('/login') }}">Login</a></li>
          <li><a href="{{ url('/register') }}">Register</a></li>
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>