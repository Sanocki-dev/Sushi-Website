@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

        <div id="SalesReport" class="col" style="background-color:white;">
            <h3 class="display-2">Sales Report</h3>
            <hr style="height: 2px; background-color:orange">
            <div class="p-5">

                <table class="table table-striped table-bordered table-sm display" cellspacing="0" width="100%" id="sales">
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
                        @foreach ($orders as $order)
                            @if ($order != null)
                            <tr class="data">
                                <td><a
                                        href="currentOrder/{{ $order->order_id }}">{{ str_pad($order->order_id, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td>C-{{ $order->orderInvoice->user_id }}</td>
                                <td>{{ $order->orderInvoice->user->name }}</td>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $order->pickup_date)->format('d M Y') }}
                                </td>
                                <td>{{ number_format($order->orderInvoice->amount, 2) }}</td>
                            </tr>
                            @endif
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

    <script>
        $(document).ready(function() {
            var table = $('#sales').DataTable({
                "pageLength": 25,
                "drawCallback": function(settings) {
                    var total = 0.00;
                    $('#sales > tbody  > tr').each(function(index, tr) {
                        total += parseFloat(tr.childNodes[9].innerHTML)
                        console.log(total);
                    });
                    $('#total').text(total.toFixed(2));
                }
            });
        });

    </script>
@endsection
