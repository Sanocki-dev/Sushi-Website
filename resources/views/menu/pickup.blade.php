@extends ('layouts.layout')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    <script>
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                window.location.reload();
            }
        });

    </script>
    <div class="w-75 p-5" style="margin: auto; background-color:rgba(43, 43, 43, 0.7)">

        <h3 class="display-2 text-white">Pick-up Orders</h3>
        <hr style="height: 2px; background-color:orange">
        <div style="background-color: white" class="p-5">

            <table id="Table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Order
                        </th>
                        <th class="th-sm">Name
                        </th>
                        <th class="th-sm">Pickup-Time
                        </th>
                        <th class="th-sm">Pickup-Date
                        </th>
                        <th class="th-sm">Amount Due
                        </th>
                        <th class="th-sm">Paid Online
                        </th>
                        <th class="th-sm">Status
                        </th>
                        <th class="th-sm">
                            Complete Transaction
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                        $userOrder = $order->orderInvoice->user_id;
                        $Count = $invoices->where('user_id', $userOrder)->count()
                        @endphp

                        <tr>
                            <td><a
                                    href="currentOrder/{{ $order->order_id }}">{{ str_pad($order->order_id, 5, '0', STR_PAD_LEFT) }}</a>
                            </td>
                            <td>{{ $order->orderInvoice->user->name }}</td>


                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $order->pickup_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $order->pickup_date)->format('M jS') }}
                            </td>
                            @if ($order->orderInvoice->paid)
                                <td class="text-success">${{ number_format($order->orderInvoice->amount,2) }} </td>
                                <td class="text-success">PAID</td>
                            @else
                                <td class="text-danger">${{ number_format($order->orderInvoice->amount,2) }} </td>
                                <td class="text-danger">NOT-PAID</td>
                            @endif

                            @php $status = $order->status @endphp
                            @if ($status == 'R')
                                <td class="text-danger">RECIEVED</td>
                            @elseif ($status == 'O')
                                <td class="text-primary">OPENED</td>
                            @else
                                <td class="text-success">READY FOR PICK-UP</td>
                            @endif
                            <td align="Center">
                                <a href="/completeTransaction/{{ $order->order_id }}" class="btn btn-primary"
                                    style="background-color:orange; border:none; font-weight:bold">Complete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#Table').DataTable()
        });

    </script>
@endsection
