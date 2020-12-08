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
        <h3 class="display-2 text-white">Current Orders</h3>
        <hr style="height: 2px; background-color:orange">
        <div style="background-color: white" class="p-5">
            
            <table id="Table" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Order
                        </th>
                        <th class="th-sm">Name
                        </th>
                        <th class="th-sm">Total Orders
                        </th>
                        <th class="th-sm">Pickup-Time
                        </th>
                        <th class="th-sm">Pickup-Date
                        </th>
                        <th class="th-sm">Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                    @foreach ($invoices as $invoice)
                    @php
                    @endphp
                    @if ($invoice->status != 'C')
                    @php
                        $Count = $orders[0]->invoice::where('user_id',$invoice->user_id)->count()
                        @endphp

<tr>
    <td><a
        href="currentOrder/{{ $invoice->invoice_id }}">{{ str_pad($invoice->invoice_id, 5, '0', STR_PAD_LEFT) }}</a>
    </td>
    <td>{{ $invoice->user->name }}</td>
    @if ($Count == 1)
    <td class="text-success font-weight-bold">***
        @elseif ($Count % 5 == 0)
        <td class="text-danger font-weight-bold">**
            @else
            <td class=".text-default font-weight-bold">
                @endif
                
                {{ $Count }}</td>
            </td>
            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $invoice->pickup_time)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->pickup_date)->format('M jS') }}</td>
            @php $status = $invoice->status @endphp
                            @if ($status == 'R')
                                <td class="text-danger">RECIEVED</td>
                            @elseif ($status == 'O')
                                <td class="text-primary">OPENED</td>
                            @else
                                <td class="text-success">COMPLETE</td>
                            @endif
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#Table').DataTable()
        });

    </script>
@endsection
