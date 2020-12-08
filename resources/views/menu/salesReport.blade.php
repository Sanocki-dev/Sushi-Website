@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <script>
        function Sales() {
            var x = document.getElementById("SalesReport");
            var y = document.getElementById("UseReport");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
            }
        }

        function Usage() {
            var x = document.getElementById("UseReport");
            var y = document.getElementById("SalesReport");
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
            }
        }

    </script>
    <div class="container w-100">

        <div class="row">
            <div class="col col-lg-2 text-white">
                <h1 class="display-2">Reports</h1>
                <hr style="height: 2px; background-color:orange">
                <button id="SalesBtn" type="button" onclick="Sales()"
                    class="list-group-item list-group-item-action">Sales</button>
                <button id="UseBtn" type="button" onclick="Usage()"
                    class="list-group-item list-group-item-action">Usage</button>
            </div>
            <div id="SalesReport" class="col" style="background-color:white;">
                <h3 class="display-2">Sales Report</h3>
                <hr style="height: 2px; background-color:orange">
                <div class="p-5">

                    <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%"
                        id="sales">
                        <thead class="thead-dark">
                            <tr>
                                <th class="th-sm">Order
                                </th>
                                <th class="th-sm">User ID
                                </th>
                                <th class="th-sm">Name
                                </th>
                                <th class="th-sm">Order Date
                                </th>
                                <th class="th-sm" class="w-25">Invoice Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @php
                                $Count = $orders[0]->invoice::where('user_id',$invoice->user_id)->count();
                                @endphp
                                <tr class="data">
                                    <td><a
                                            href="currentOrder/{{ $invoice->invoice_id }}">{{ str_pad($invoice->invoice_id, 5, '0', STR_PAD_LEFT) }}</a>
                                    </td>
                                    <td>C-{{ $invoice->user_id }}</td>
                                    <td>{{ $invoice->user->name }}</td>
                                    </td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s', $invoice->date)->format('d M Y') }}
                                    </td>
                                    <td>{{ number_format($invoice->amount, 2) }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th id="total"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div id="UseReport" class="col" style="display:none; background-color:white" class="w-75 float-right p-5">
                <h3 class="display-2">Usage Report</h3>
                <hr style="height: 2px; background-color:orange">
                <div class="p-5">
                <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="usage">
                    <thead>
                        <tr>
                            <th class="th-sm">Item ID
                            </th>
                            <th class="th-sm">Name
                            </th>
                            <th class="th-sm">Name
                            </th>
                            <th class="th-sm">Order Date
                            </th>
                            <th class="th-sm" class="w-25">Invoice Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            @php
                            $Count = $orders[0]->invoice::where('user_id',$invoice->user_id)->count();
                            @endphp
                            <tr class="data">
                                <td><a
                                        href="currentOrder/{{ $invoice->invoice_id }}">{{ str_pad($invoice->invoice_id, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td>C-{{ $invoice->user_id }}</td>
                                <td>{{ $invoice->user->name }}</td>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->pickup_date)->format('d M Y') }}
                                </td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th id="total"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#sales').DataTable({
                "drawCallback": function(settings) {
                    var total = 0.00;
                    $('#sales > tbody  > tr').each(function(index, tr) {
                        total += parseFloat(tr.childNodes[9].innerHTML)
                        console.log(total);
                    });
                    $('#total').text(total.toFixed(2));
                }
            });

            var table = $('#usage').DataTable({
                "drawCallback": function(settings) {
                    var total = 0.00;
                    $('#usage > tbody  > tr').each(function(index, tr) {
                        total += parseFloat(tr.childNodes[9].innerHTML)
                        console.log(total);
                    });
                    $('#total').text(total.toFixed(2));
                }
            });

        });

    </script>
@endsection
