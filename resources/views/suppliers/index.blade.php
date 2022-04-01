@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <div id="SalesReport" class="col" style="background-color:white;">

        <h3 class="display-2">Suppliers</h3>
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
        <div class="w-50 p-5">
            <h3 class="display-4">New Supplier</h3>
            <form action="{{ route('supplier.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2 mb-2">
                        <label for="cc-number">Supplier Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="cc-number">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="cc-number">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="cc-number">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="cc-number">Website</label>
                        <input type="text" class="form-control" id="website" name="website" placeholder="">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="cc-number">Comments</label>
                        <input type="text" class="form-control" id="comments" name="comments" placeholder="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary "
                    style="background-color:orange; border:none; font-weight:bold">Submit</button>
            </form>
        </div>
        <div class="p-5">
            <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="sales">
                <thead class="thead-dark">
                    <tr>
                        <th class="th-sm">Supplier
                        </th>
                        <th class="th-sm">Address
                        </th>
                        <th class="th-sm">Phone
                        </th>
                        <th class="th-sm">Email
                        </th>
                        <th class="th-sm">Website
                        </th>
                        <th class="th-sm">Comments
                        </th>
                        <th class="th-sm">Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr class="data">
                            <td><a href="supplier/{{ $supplier->supplier_id }}">{{ $supplier->name }}</a>
                            </td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->phone }}</td>
                            </td>
                            <td>{{ $supplier->email }}
                            </td>
                            <td><a href="{{ $supplier->website }}">Site</a></td>
                            <td>{{ $supplier->comments }}</td>
                            <td>
                                <form action="{{ route('supplier.delete', ['id' => $supplier['supplier_id']]) }}"
                                    method="post" style="display: inline">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit"
                                        style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                                </form>
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
