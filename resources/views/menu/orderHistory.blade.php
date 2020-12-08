<div class="col-sm-8">

    <h2 style="color:orange; margin-bottom:20px">
        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->pickup_date)->format('M d,Y') }} at
        {{ \Carbon\Carbon::createFromFormat('H:m:s', $invoice->pickup_time)->format('h:m a') }}
    </h2>
    @foreach ($history as $item)
        @if ($invoice->invoice_id == $item->invoice_id)
            <h3 style="font-weight: lighter;"> <strong style="font-weight:bold">{{ $item->quantity }}x</strong>
                {{ $menu[$item->menu_id]->name }}
            </h3>
        @endif
    @endforeach
    <h3 style="font-weight: lighter;  margin-top:20px ;  margin-bottom:20px">Total Purchase Price: <strong
            style="font-weight:bold">${{ number_format($invoice->amount, 2) }}</strong> </h3>
</div>
<hr style="height: 2px; background-color:rgb(0, 159, 170);">
<hr>
