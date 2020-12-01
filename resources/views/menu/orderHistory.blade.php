<div class="col-sm-8">

<p>Amount of Sushi Purchased: </p>
    @foreach ($history as $item)
        @if ($invoice->invoice_ID == $item->invoice_ID)
            <p>{{ $menu[$item->menu_ID]->name }} {{ $item->quantity }}</p> 
        @endif
    @endforeach
<p></p>

<p>Price of Sushi Purchased: ${{ $invoice->amount }}
	
</p>

<p></p>

<p>Order Time: {{ $invoice->date }} @ {{ $invoice->time }}</p>

</div>

<hr>