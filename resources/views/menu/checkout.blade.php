@extends ('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1>Checkout</h1>
            <h4>Total Purchase: ${{ $total }}</h4>
            <form action="{{ route('checkout') }}" method="POST">
                
            </form>
        </div>
    </div>
@endsection