@extends ('layouts.layout')

@section('content')

<script>
const zeroPad = (num, places) => String(num).padStart(places, '0')

        function savedCardInfo() {
            var info = {!! json_encode($credit->toArray()) !!};
            var year = new Date(info[0].exp_Date).getFullYear();
            var month = new Date(info[0].exp_Date).getMonth() + 1;
            var dateFormatted = year + "-" + zeroPad(month,2);
            document.getElementById("cc-name").value = info[0].name;
            document.getElementById("cc-number").value = info[0].number;
            document.getElementById("cc-expiration").value = dateFormatted;
            console.log(info[0].pay_id);
            document.getElementsByName("paymentMethod")[info[0].pay_id-1].checked = true
        }

        function newCardInfo() {
            document.getElementById("cc-name").value = "";
            document.getElementById("cc-number").value = "";
            document.getElementById("cc-expiration").value = "";
        }
    </script>

    <hr>
    <h1 style="text-align: center">Overview</h1>
    <hr>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4 ">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            @if (Session::has('cart'))
                <ul class="list-group mb-3">
                    @foreach ($items as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{ $item['qty'] }}x {{ $item['item']['name'] }}</h6>
                                <a href="#" class="text-muted">Remove</a>
                            </div>
                            <span class="text-muted">${{ $item['price'] }}</span>
                        </li>
                    @endforeach
                    @if (Session::has('promo'))
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <div class="text-success">
                            <h6 class="my-0">Promo code</h6>
                            <small>EXAMPLECODE</small>
                        </div>
                        <span class="text-success">-$5</span>
                    </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (CAD)</span>
                        <strong>${{ $totalPrice }}</strong>
                    </li>
                @else
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Nothing in your cart!</h6>
                    </div>
                </li>
            @endif
            </ul>

            <form class="card p-2 w-100">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 order-md-1">
            <form class="needs-validation" method="POST" action="#">
                {{ csrf_field() }}
                <h4 class="mb-3">Pickup-Time</h4>
                <div class="d-block my-3" id="ccformContainer">
                    <div class="custom-control custom-radio">
                        <input id="time" name="time" type="time"
                            class="form-check-input" required>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="date" name="date" type="date" class="form-check-input" required>
                    </div>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3" id="ccformContainer">
                    <div class="custom-control custom-radio">
                        <input onClick="savedCardInfo()" id="existing" value="0" name="paymentType" type="radio"
                            class="form-check-input" required>
                        <label class="custom-control-label" for="existing">Use existing card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input onClick="newCardInfo()" id="existing" value="0" name="paymentType" type="radio"
                            class="form-check-input" required>
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
                        <input onClick="newCardInfo()" id="debit" value="2" name="paymentMethod" type="radio" class="form-check-input"
                            required>
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
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" name="cc-number" minlength="16" maxlength="16" placeholder="" required>
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
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" minlength="3" maxlength="3" required>
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
                            <small class="text-muted">Will overwrite existing card data</small>
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
    </div>
@endsection
