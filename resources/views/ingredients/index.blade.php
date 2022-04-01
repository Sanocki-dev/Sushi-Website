@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <div id="SalesReport" class="col" style="background-color:white;">
        <h3 class="display-2">Ingredients</h3>
        <hr style="height: 2px; background-color:orange">
        <div class="p-5">
            <h3 class="display-4">New Supplier Ingredient</h3>
            <form action="/ingredients" method="POST" class="mb-5">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-2 m-2">
                        <label for="cc-number">Supplier</label><br>
                        <select name="suppliers" id="supplier" class="p-2">
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 m-2">
                        <label for="cc-number">Ingredient</label><br>
                        <select name="ingredients" id="ingredient" class="p-2">
                            @foreach ($allIngredients as $ingredient)
                                <option value="{{ $ingredient->ingredient_id }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 m-2">
                        <label for="cc-number">Price</label>
                        <input type="text" class="form-control" id="Price" name="Price" placeholder="Price" required>
                    </div>
                    <div class="col-md-4 m-2">
                        <label for="cc-number">Details</label>
                        <input type="text" class="form-control" id="Details" name="Details" placeholder="Details" >
                    </div>
                </div>
                <button type="submit" class="btn btn-primary m-2"
                    style="background-color:orange; border:none; font-weight:bold">Submit</button>
            </form>


            <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="sales">
                <thead class="thead-dark">
                    <tr>
                        <th class="th-sm">Supplier
                        </th>
                        <th class="th-sm">Ingredient
                        </th>
                        <th class="th-sm">Price
                        </th>
                        <th class="th-sm">Details
                        </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ingredients as $ingredient)
                        <tr class="data">
                            <td><a
                                    href="supplier/{{ $ingredient->supplier->supplier_id }}">{{ $ingredient->supplier->name }}</a>
                            </td>
                            <td>{{ $ingredient->ingredient->name }}</td>
                            <td>{{ number_format($ingredient->price, 2) }}</td>
                            <td>{{ $ingredient->details }}</td>
                            <td>
                                <form action="{{ route('ingredient.delete', ['supplier_id' => $ingredient->supplier->supplier_id, 'ingredient_id' => $ingredient->ingredient->ingredient_id ]) }}"
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
