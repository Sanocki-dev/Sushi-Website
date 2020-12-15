<div class="col-sm-8">

    <h2 style="color:orange; margin-bottom:20px">
        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->invoiceOrder->pickup_date)->format('M d,Y') }} at
        {{ \Carbon\Carbon::createFromFormat('H:m:s', $invoice->invoiceOrder->pickup_time)->format('h:m a') }}
    </h2>
    @php
        $items = $invoice->invoiceOrder->orderItems
    @endphp
    @foreach ($items as $item)

            <h3 style="font-weight: lighter;"> <strong style="font-weight:bold">{{ $item->quantity }}x</strong>
                {{ $item->menuItem->name }}
            </h3>
    @endforeach
    <h3 style="font-weight: lighter;  margin-top:20px ;  margin-bottom:20px">Total Purchase Price: <strong
            style="font-weight:bold">${{ number_format($invoice->amount, 2) }}</strong> </h3>
</div>
<hr style="height: 2px; background-color:rgb(0, 159, 170);">
<hr>
