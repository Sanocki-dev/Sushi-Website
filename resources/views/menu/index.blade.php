@extends ('layouts.layout')

@section ('content')
<body class="home-bg">
	<div class="container">
		{{-- <div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Dashboard</div>

					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif

						You are logged in!
					</div>
				</div> --}}

		<div class="jumbotron">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-responsive logo" src="{{ asset('/images/SushiBaiKiyoshiLogo.png') }}">
                    {{-- <img src="..." alt="..." class="img-thumbnail"> --}}
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                </a>			
			<h1 class="display-4">Welcome!</h1>
			<p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
			<hr class="my-4">
			<p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
		</div>
	</div>
</body>
@endsection