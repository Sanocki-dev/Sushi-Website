<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ url('/') }}">
      <img class="img-responsive logo" src="{{ asset('/images/SushiBaiKiyoshi.png') }}">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/about">About</a>
      </li>
      <li class="nav-item">
         @if (! Auth::check())
        <a class="nav-link" href="/about">Menu</a>
         @endif
      </li>
      <li class="nav-item">
         @if (Auth::check())
         @if (Auth::user()->userType == 'A')
         <a class="nav-link" href="/editMenu">Edit Order Menu</a>
         @endif
         @endif
      </li>
      <li class="nav-item">
         @if (Auth::check())
         @if (Auth::user()->userType == 'A')
         <a class="nav-link" href="/currentOrders">Current Orders</a>
         @endif
         @endif
      </li>
      <li class="nav-item">
         @if (Auth::check())
          @if (Auth::user()->userType == 'C')
          <a class="nav-link" href="/orderMenu">Order Menu</a>
          @endif
         @endif
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        @if (! Auth::check())
          <a class="nav-link" href="/login">Log in</a>
        @endif
      </li>
      <li class="nav-item">
        @if (! Auth::check())
          <a class="nav-link" href="/register">Register</a>
        @endif
      </li>      
      
      <li class="nav-item">
        @if (Auth::check())   
        @if (Auth::user()->userType == 'C')
        <div class="btn-group navSpace float-right" >
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="/history">History</a>
            <a class="dropdown-item" href="/account">Account Information</a>
            <a class="dropdown-item" href="/logout">Logout</a>
          </div>
        </div>       
        @endif
        @endif
      </li>            
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
  </div>
</nav>
</div>