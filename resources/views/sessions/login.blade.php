@extends ('layouts.layout')

@section('content')

    <div class="w-50 mt-5 p-5" style="margin: auto;color:white; background-color:rgba(43, 43, 43, 0.7)">
        <h1 class="display-2" >Log in</h1>
        <hr style="height: 2px; background-color:orange">

        @include('layouts.errors')
        <form method=POST action="/login">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <a href="/forgotPassword" class="navbar-brand navSpace" style="color:rgb(0, 159, 170)">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-primary " style="background-color:orange; border:none; font-weight:bold">Submit</button>
        </form>

    </div>

@endsection
