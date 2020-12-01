@extends ('layouts.layout')

@section ('content')

	<div class="col-sm-8">

		<h1>Log in</h1>

		<hr>

<form method=POST action="/login">

  {{ csrf_field() }}

  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    <a href="/forgotPassword" class="navbar-brand navSpace">Forgot Password?</a>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>

	</div>

@endsection