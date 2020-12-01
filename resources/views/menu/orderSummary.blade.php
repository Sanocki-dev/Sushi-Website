@extends ('layouts.layout')

@section('content')
    <hr>
    <h1 style="text-align: center">Overview</h1>
    <hr>
    @php $count = 0; $total = 0;@endphp
    <form method="POST" action="/orderItems">
        {{ csrf_field() }}
        <table class="table table-striped table-dark table-hover" style="width: 80%; margin:auto">
            <thead class="thead-dark">
                <tr>
                    <th style="font-size: 20pt; width:33%;text-align:center" scope="col">Item</th>
                    <th style="font-size: 20pt; width:33%;text-align:center" scope="col">Price</th>
                    <th style="font-size: 20pt; text-align:center" scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($ordered as $item)
                    @php $count++; @endphp
                    @if ($item != 0)
                        @foreach ($menu_items as $menu_item)

                            @if ($menu_item->menu_ID == $count)
                                <tr class="align-middle" style="font-size: 15pt;text-align: center">
                                    <th>
                                        <input style="display:none"
                                            type="text" id="menu_id[]" name="menu_id[]" value="{{ $menu_item->menu_ID }}"
                                            readonly>
                                            <input style="background:none; border:none; text-align:center; color: white;"
                                            type="text" value="{{ $menu_item->name }}"
                                            readonly>
                                    </th>
                                    <td class="align-middle" style="font-size: 15pt;">
                                        @php
                                        $total += $menu_item->price*$item;
                                        @endphp
                                        ${{ number_format($menu_item->price * $item, 2) }}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary">-</button>
                                        <input
                                            style="background:none; border:none; text-align:center; color: white; width:50px;"
                                            type="text" id="amount[]" name="amount[]" value="{{ $item }}" readonly>
                                        <button class="btn btn-primary">+</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <tr style="text-align: right">
                    <th style="font-size:15pt">Tax:</th>
                    <td style="font-size:15pt">
                        <input style="background:none; border:none; text-align:right; color: white" type="text" name="tax"
                            id="tax" value="@php
                                echo '$', number_format($total*.13, 2);
                                @endphp" readonly>
                    </td>
                    <td></td>
                </tr>
                <tr style="text-align: right">
                    <th style="font-size:15pt">Total:</th>
                    <td class="align-middle" style="font-size:15pt">
                        <input style="background:none; border:none; text-align:right; color: white"
                         type="text" name="pay"
                            id="pay" value="@php
                                echo $total*1.13
                                @endphp" readonly>
                    </td>
                    <td>
                    </td>
                </tr>
        </table>
        <hr>
        <h1 style="text-align: center">Pick-up Time</h1>
        <hr>
        <label for="" style="margin-left: 30%; font-weight:bold">Time</label>
        <input type="time" id="time" name="time">
        <label for="" style="margin-left: 10%; font-weight:bold">Date</label>
        <input type="date" id="date" name="date">
        <hr>
        <h1 style="text-align: center">Payment</h1>
        <hr>
        <div style="width: 50%; margin:auto; padding: 20px;">
            <label for="cars">Payment Method:</label>

            <select name="payment_type" id="payment_type">
                <option value="1">MasterCard</option>
                <option value="2">Visa Debit</option>
            </select>

            <div class="form-group">
                <label for="number">Credit Number</label>
                <input type="text" class="form-control" id="number" name="number" placeholder="XXXX-XXXX-XXXX-XXXX">
            </div>
            <div class="form-group">
                <label for="exp_Date">Expiry Date</label>
                <input type="month" class="form-control" id="exp_Date" name="exp_Date">
            </div>
            <div class="form-group">
                <label for="name">Card Owners Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="CVV">CVV</label>
                <input type="text" class="form-control" id="CVV" name="CVV" placeholder="XXX">
            </div>
            <div style="width: 100%; text-align:center; padding: 10px">
                <button type="submit" class="btn btn-primary" style="margin:auto">Proceed with Payment</button>
            </div>
        </div>
    </form>

@endsection
