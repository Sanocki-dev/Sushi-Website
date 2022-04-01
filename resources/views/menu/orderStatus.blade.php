@extends ('layouts.layout')

@section('content')

    <div class="w-75 p-5" style="margin:auto; color:white; background-color: rgba(43, 43, 43, 0.7)">
        @if (session()->has('success'))
            <div class="spacer">
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            </div>
        @endif
        <h1 class="display-2 ">Your Orders</h1>
        <hr style="height: 2px; background-color:orange">
        <table id="Table" class="table table-striped table-hover mt-5" cellspacing="0" width="100%"
            style="background-color: white; color:black">
            <thead>
                <tr>
                    <th scope="col">Order
                    </th>
                    <th scope="col">Amount</th>
                    <th scope="col">Pickup-Time
                    </th>
                    <th scope="col">Status
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                $count = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <td style="font-weight: bold">{{ $count++ }}</td>
                        <td>${{ number_format($order->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $order->invoiceOrder->pickup_date)->format('M d,Y') }}
                            at
                            {{ \Carbon\Carbon::createFromFormat('H:m:s', $order->invoiceOrder->pickup_time)->format('h:m a') }}
                        </td>
                        @if ($order->invoiceOrder->status == 'R')
                            <td>Receieved your order</td>
                        @elseif ($order->invoiceOrder->status == "O")
                            <td>Working on your order</td>
                        @elseif ($order->invoiceOrder->status == "C")
                            <td>Your order is ready for pick-up</td>
                        @else
                            <td>Order has been picked up</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
