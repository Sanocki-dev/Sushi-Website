@extends ('layouts.layout')

@section ('content')

<div class="col-sm-8">

		<h1>Order Items</h1>

		<hr>

  @foreach ($menu_items as $items)
    <h1>{{ $items->name }}</h1>
  @endforeach
  @foreach ($input as $put)
    <h1>{{ $put->total }}</h1>
  @endforeach

	</div>

@endsection