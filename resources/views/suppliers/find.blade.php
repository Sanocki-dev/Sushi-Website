@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <div id="SalesReport" class="col" style="background-color:white;">

        @if ($flash = session('success'))
            <div id="flash-message" class="alert alert-success" role="alert">
                {{ $flash }}
            </div>
        @endif
        <h3 class="display-2">{{ $supplier->name }}</h3>
        <hr style="height: 2px; background-color:orange">
        @if (session()->has('success'))
            <div class="spacer">
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="spacer">
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <strong>{{ $error }}</strong><br>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="p-5">
            <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="sales">
                <thead class="thead-dark">
                    <tr>
                        <th class="th-sm">Item
                        </th>
                        <th class="th-sm">Price
                        </th>
                        <th class="th-sm">Details
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplierItems as $item)
                        <tr class="data">
                            <td>{{ $item->ingredient->name }}</td>
                            <td>{{ $item->price }}</td>
                            </td>
                            <td>{{ $item->details }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#sales').DataTable({
                "pageLength": 25,
            });
        });

    </script>

@endsection
