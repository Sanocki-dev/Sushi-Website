
    <div class="collapse bg-inverse" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 py-4">         
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-inverse bg-inverse">
      <div class="float-left">
        <a class="navSpace"></a>
        <a href="/" class="navbar-brand navSpace">Home</a>
        <a href="/about" class="navbar-brand navSpace">About</a>
         @if (! Auth::check())
          <a href="/menu" class="navbar-brand navSpaceTwo">Menu</a>
         @endif

         @if (Auth::check())
         @if (Auth::user()->userType == 'A')
         <a href="/editMenu" class="navbar-brand navSpace">Edit Order Menu</a>
         <a href="/currentOrders" class="navbar-brand navSpaceTwo">Current Orders</a>
         @endif
         @endif

         @if (Auth::check())
          @if (Auth::user()->userType == 'C')
          <a href="/orderMenu" class="navbar-brand navSpaceTwo">Order Menu</a>
          @endif
         @endif

        @if (! Auth::check())
        <div class="btn-group navSpace float-right">
          <a href="/login" class="navbar-brand navSpace">Log in</a>
          <a href="/register" class="navbar-brand">Register</a>
        </div>
        @endif

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

        @if (Auth::check())   
        @if (Auth::user()->userType == 'A')
        <div class="btn-group navSpace float-right">
          <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Reports
          </button>
          <div class="dropdown-menu">
            <a href="/salesReport" class="dropdown-item">Sales Reports</a>
            <a class="dropdown-item" href="/logout">Logout</a>
          </div>
        </div>       
          
        @endif
        @endif

        </button>
      </div>
    </div>