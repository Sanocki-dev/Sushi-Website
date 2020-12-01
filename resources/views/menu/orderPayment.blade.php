@extends ('layouts.layout')

@section ('content')

<div class="col-sm-8">

		<h1>Pay for Order</h1>

		<hr>

<form method="GET" action="/orderItems">
  {{ csrf_field() }}

<label for="cars">Payment Method:</label>

<select name="type" id="type">
  <option value="1">MasterCard</option>
  <option value="2">Visa Debit</option>
</select>
  <div class="form-group">
    <label for="number">Credit Number</label>
    <input type="text" class="form-control" id="number" name="number">
  </div>
  <div class="form-group">
    <label for="exp_Date">Expiry Date</label>
    <input type="month" class="form-control" id="exp_Date" name="exp_Date">
  </div>
  <div class="form-group">
    <label for="name">Card Owners Name</label>
    <input type="text" class="form-control" id="name" name="name">
  </div>
  <button type="submit" class="btn btn-primary">Submit Payment</button>
</form>
	</div>

@endsection