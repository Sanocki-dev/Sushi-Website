@extends ('layouts.layout')

@section('content')

    <script>
        function myFunction(index) {
            $('#promoCode').val(index);
        }

        function savedCardInfo() {
            var info =  {!! json_encode($credit->toArray()) !!};
            if (info.length != 0) 
            {
                var year = new Date(info[0].exp_Date).getFullYear();
                var month = new Date(info[0].exp_Date).getMonth() + 1;
                var dateFormatted = year + "-" + zeroPad(month, 2);
                document.getElementById("cc-name").value = info[0].name;
                document.getElementById("cc-number").value = info[0].number;
                document.getElementById("cc-expiration").value = dateFormatted;
                console.log(info[0].pay_id);
                document.getElementsByName("paymentMethod")[info[0].pay_id - 1].checked = true;
            } 
            else 
            {
                var x = document.getElementById("message");
                if (x.style.display === "none") 
                {
                    x.style.display = "block";
                }
                document.getElementsByName("paymentType")[1].checked = true;

            }
        }
        const zeroPad = (num, places) => String(num).padStart(places, '0');
    </script>

    @php
    $discount = 0;
    @endphp

    <h1 style="color:white; margin-top:20px" class="display-2">Overview</h1>
    <hr style="height: 2px; background-color:orange">
    <div class="row w-75 p-5" style="margin: auto; background-color:rgba(75, 75, 75, 0.651)">
        <div class="col-md-4 order-md-2 mb-4 ">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span style="color:orange">Your cart</span>
            </h4>
            @if (Session::has('cart'))
                <ul class="list-group mb-3" id="orderList">
                    @foreach ($items as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><span style="font-weight: bold; color:orange">
                                        {{ $item['qty'] }}x</span> {{ $item['item']['name'] }}
                                    <form action="{{ route('cart.destroy', ['id' => $item['item']['menu_id']]) }}"
                                        method="post" style="display: inline">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit"
                                        style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                                    </form>
                                </h6>
                            </div>
                            <div>
                                @foreach ($promos as $promo)
                                    @if ($promo->menu_id == $item['item']['menu_id'])
                                        <small id="PromoCode" onclick="myFunction('{{ $promo->code }}')" class="text-success">
                                            Promo!
                                        </small>
                                    @endif
                                @endforeach
                                <span style="font-size: 15pt; color:orange">${{ number_format($item['price'], 2) }}</span>
                            </div>
                        </li>
                    @endforeach
                    {{-- session()->get('cart')->items[1]['price'] *
                    --}}
                    @if (Session::has('promotion'))
                        <li class="list-group-item d-flex justify-content-between text-success">
                            <h6 class="my-0">Promo Code: <strong>{{ session()->get('promotion')['code'] }}</strong>
                            <form action="{{ route('promo.destroy') }}" method="post" style="display: inline">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                            </form>
                        </h6>
                            <strong style="font-size: 16pt">-${{ session()->get('promotion')['item_discount'] }}</strong>
                        </li>
                        @php
                        $discount = session()->get('promotion')['item_discount'];
                        @endphp
                    @endif
                    <li class="list-group-item d-flex justify-content-between" style="background-color:rgb(0, 159, 170,.7); color:white; font-size: 16pt">
                        <span >Tax (13%)</span>
                        <strong>${{ number_format(($totalPrice - $discount) * 0.13, 2) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between" style="background-color:rgb(0, 159, 170,.7); color:white; font-size: 16pt">
                        <span>Total (CAD)</span>
                        <strong>${{ number_format(($totalPrice - $discount) * 1.13, 2) }}</strong>
                    </li>
                @else
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Nothing in your cart!</h6>
                        </div>
                    </li>
            @endif
            </ul>
            @if (session()->has('success'))
                <div class="spacer">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="spacer">
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>
            @endif
            <form action="{{ route('promo.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="input-group" style="">
                    <input type="text" class="form-control" placeholder="Promo code" name="promoCode" id="promoCode">
                    <div class="input-group-append">
                        <button class="btn" style="background-color:orange; color:white">Redeem</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 order-md-1" style="color:white">
            <form class="needs-validation" method="POST" action="#">
                {{ csrf_field() }}
                <h4 class="mb-3" style="color:orange">Pickup-Time</h4>
                <div class="d-block my-3" id="ccformContainer">
                    <div class="custom-control custom-radio">
                        <input id="time" name="time" type="time" class="form-check-input" required>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="date" name="date" type="date" class="form-check-input" required>
                    </div>
                </div>
                <hr style="height: 2px; background-color:orange">
                <div id="message" style="display: none" class="alert alert-danger" role="alert">
                    No card on file!
                </div>
                <h4 class="mb-3" style="color:orange">Payment</h4>
                <div class="d-block my-3" id="ccformContainer">
                    <div class="custom-control custom-radio">
                        <input onClick="savedCardInfo()" id="existing" value="0" name="paymentType" type="radio"
                            class="form-check-input" required>
                        <label class="custom-control-label" for="existing">Use existing card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input checked id="existing" value="0" name="paymentType" type="radio" class="form-check-input"
                            required>
                        <label class="custom-control-label" for="existing">New payment</label>
                    </div>
                </div>
                <div class="d-block my-3" id="ccformContainer">
                    <div class="custom-control custom-radio">
                        <input onClick="newCardInfo()" id="credit" value="1" name="paymentMethod" type="radio"
                            class="form-check-input" required>
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input onClick="newCardInfo()" id="debit" value="2" name="paymentMethod" type="radio"
                            class="form-check-input" required>
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input onClick="newCardInfo()" id="paypal" value="3" name="paymentMethod" type="radio"
                            class="form-check-input" required>
                        <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                </div>
                <div class="row" id="A">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
                        <small>Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" name="cc-number" minlength="16"
                            maxlength="16" placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="month" class="form-control" id="cc-expiration" name="cc-expiration" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" minlength="3" maxlength="3"
                            required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-check-label" for="saveDetails">
                            <input class="form-check-input" type="checkbox" value="1" id="saveCard" name="saveCard">
                            Save Card Details
                        </label>
                        <div>
                            <small>Will overwrite existing card data</small>
                        </div>
                    </div>
                </div>

                <hr style="height: 2px; background-color:orange">
                <button class="btn btn-lg btn-block" style="background-color:orange; color:white" type="submit">Complete Order</button>
            </form>
        </div>
    </div>
    </div>
@endsection
