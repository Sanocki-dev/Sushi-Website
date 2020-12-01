@extends ('layouts.layout')

@section ('content')

<div class="col-sm-8">

		<h1>Order History</h1>

		<hr>

	@foreach ($invoices as $invoice)

			@include ('menu.orderHistory')

	@endforeach	

</div>

@endsection