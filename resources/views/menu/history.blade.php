@extends ('layouts.layout')

@section ('content')

<div class="col-sm-8 text-white w-75 p-5" style="margin: auto; background-color:rgba(56, 56, 56, 0.651)">

	<h1 class="display-2 ">Order History</h1>

		<hr style="height: 2px; background-color:orange">

	@foreach ($invoices as $invoice)
			@include ('menu.orderHistory')
	@endforeach	

</div>

@endsection