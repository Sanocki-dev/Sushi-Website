@extends ('layouts.layout')

@section ('content')

	<div class="col-sm-8">

		<h1>Sign Up</h1>

		<hr>

<form method=POST action="/register">

  {{ csrf_field() }}

  <div class="form-group">
    <label for="name">Name</label>
    <input type="name" class="form-control" id="name" name="name" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="promotions">Would you like to recieve promotions?</label>
      <input type="checkbox" class="form-control" id="promotions" name="promotions" checked>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
	</div>

@endsection