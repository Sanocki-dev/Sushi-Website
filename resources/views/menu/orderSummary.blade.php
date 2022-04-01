@extends ('layouts.layout')

@section('head.extras')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

    <script>
        function myFunction(index) {
            $('#promoCode').val(index);
        }

        function inStore() {
            $("#instore").show();
            $("#credit").hide();
        }

        function credit() {
            $("#instore").hide();
            $("#credit").show();
        }

        const zeroPad = (num, places) => String(num).padStart(places, '0');

    </script>

    @php
    $discount = 0;
    @endphp

    <div class="w-75 p-5" style="margin: auto; background-color:rgba(43, 43, 43, 0.7)">

        <h1 style="color:white; margin-top:20px" class="display-2">Overview</h1>

        <hr style="height: 2px; background-color:orange">
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
                        <strong>{{ $error }}</strong><br>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row w-100" style="margin: auto;">
            <div class="col-md-5 order-md-2 mb-4 ">
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
                                            <small id="PromoCode" onclick="myFunction('{{ $promo->code }}')"
                                                class="text-success">
                                                Promo!
                                            </small>
                                        @endif
                                    @endforeach
                                    <span
                                        style="font-size: 15pt; color:orange">${{ number_format($item['price'], 2) }}</span>
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
                                        <button type="submit"
                                            style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                                    </form>
                                </h6>
                                <strong
                                    style="font-size: 16pt">-${{ session()->get('promotion')['item_discount'] }}</strong>
                            </li>
                            @php
                            $discount = session()->get('promotion')['item_discount'];
                            @endphp
                        @endif
                        <li class="list-group-item d-flex justify-content-between"
                            style="background-color:rgb(0, 159, 170,.7); color:white; font-size: 16pt">
                            <span>Tax (13%)</span>
                            <strong>${{ number_format($totalTax, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between"
                            style="background-color:rgb(0, 159, 170,.7); color:white; font-size: 16pt">
                            <span>Total (CAD)</span>
                            <strong>${{ number_format($totalDue, 2) }}</strong>
                        </li>
                    @else
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Nothing in your cart!</h6>
                            </div>
                        </li>
                @endif
                </ul>

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

            <div class="col-md-7 order-md-1" style="color:white">
                <h4 class="mb-3" style="color:orange">Payment</h4>
                <div class="form-check-inline">
                    <input class="" type="radio" name="inlineRadioOptions" id="payment" value="0" onclick="inStore()">
                    <label class="" for="inlineRadio1">Pay at store</label>
                </div>
                <div class="form-check-inline">
                    <input class="" type="radio" name="inlineRadioOptions" id="payment" value="1" onclick="credit()"
                        checked>
                    <label class="" for="inlineRadio2">Pay Via Credit</label>
                </div>
                <div id="dateErrors" style="display: none">
                    <small style="color: red">We are not open on weekends!</small>
                </div>
                <hr style="height: 2px; background-color:orange">
                <div id="instore" style="display: none">
                    @php
                    $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon\Carbon::now('EST')->toDateTimeString())->format('H');
                    $minTime = '08:00';
                    // Today is over
                    if ($time > 18)
                    {
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon\Carbon::now('EST')->addDay(1)->toDateTimeString())->format('Y-m-d');
                    }
                    else {
                    $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon\Carbon::now('EST')->toDateTimeString())->format('Y-m-d');
                    }

                    // If it is today
                    if ($date == \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                    Carbon\Carbon::now('EST')->toDateTimeString())->format('Y-m-d'))
                    {
                    if ($time > 8 && $time < 22) { $minTime=str_pad($time, 2, '0' , STR_PAD_LEFT) . ":00" ; } } @endphp
                        <form action="{{ route('checkout.store') }}" method="POST">
                        {{ csrf_field() }}

                        <h4 class="mb-3" style="color:orange">Pickup-Time</h4><small>store hours are between 8am - 6pm
                            Monday to
                            Friday</small>
                        <div class="d-block my-3" id="ccformContainer">
                            <div class="custom-control custom-radio">
                                <input id="time2" name="time2" type="time" class="form-check-input" min="{{ $minTime }}"
                                    max="20:00">
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="date2" name="date2" type="date" class="form-check-input" min="{{ $date }}">
                            </div>
                        </div>
                        <hr style="height: 2px; background-color:orange">
                        <button class="btn btn-lg btn-block" style="background-color:orange; color:white" id="purchase"
                            name="purchase" value='0' type="submit">Complete Order</button>
                        </form>
                </div>
                <div id="credit" style="display: show">
                    <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                        {{ csrf_field() }}
                        <h4 class="mb-3" style="color:orange">Pickup-Time</h4><small>store hours are between 8am - 6pm
                            Monday to
                            Friday</small>
                        <div class="d-block my-3" id="ccformContainer">
                            <div class="custom-control custom-radio">
                                <input id="time1" name="time1" type="time" class="form-check-input" min="{{ $minTime }}"
                                    max="18:00" required>
                            </div>
                            <div class="custom-control custom-radio">

                                <input id="date1" name="date1" type="date" class="form-check-input" min="{{ $date }}"
                                    required>
                            </div>
                        </div>
                        <hr style="height: 2px; background-color:orange">

                        <div style="display: show">
                            <h4 class="mb-3" style="color:orange">Payment Details</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Address</label>
                                    <input type="text" class="form-control" id="cc-address" name="cc-address" minlength="5"
                                        placeholder="" required>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">City</label>
                                    <input type="text" class="form-control" id="cc-city" name="cc-city" placeholder=""
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Province</label>
                                    <input type="text" class="form-control" id="cc-province" name="cc-province"
                                        placeholder="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cc-number">Postal Code</label>
                                    <input type="text" class="form-control" id="cc-postal" name="cc-postal" placeholder=""
                                        required>
                                </div>
                            </div>
                            <div class="row p-3" id="A">
                                <div class="w-50">
                                    <label for="cc-name">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder=""
                                        required>
                                    <small>Full name as displayed on card</small>
                                    <div class="invalid-feedback">
                                        Name on card is required
                                    </div>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-md-6 mb-3">
                                    <label for="card-element">
                                        Credit or debit card
                                    </label>
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                    <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert"></div>

                                </div>
                            </div>

                            <hr style="height: 2px; background-color:orange">
                            <button class="btn btn-lg btn-block" style="background-color:orange; color:white" id="purchase"
                                type="submit">Complete
                                Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        (function() {
            // Create a Stripe client.
            var stripe = Stripe(
                'pk_test_51HuNVRDlK9S3CMQS9p3Ooq0axIxjmyguCbJCp1jdt6O1HUaDV0e0hR34S8qiREVCWxxDle0IvLof5WL1HjDtVqST00vSFoy7Ie'
            );

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                document.getElementById('purchase').disable = true;
                var details = {
                    name: document.getElementById('cc-name').value,
                    address: document.getElementById('cc-address').value,
                    city: document.getElementById('cc-address').value,
                    province: document.getElementById('cc-province').value,
                    postal: document.getElementById('cc-postal').value
                }

                stripe.createToken(card, details).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        document.getElementById('purchase').disable = false;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        })();

        const picker1 = document.getElementById('date1');

        picker1.addEventListener('input', function(e) {
            var day = new Date(this.value).getUTCDay();
            if ([6, 0].includes(day)) {
                e.preventDefault();
                this.value = '';
                document.getElementById('dateErrors').style.display = "";
            }
        });

        const picker2 = document.getElementById('date2');

        picker2.addEventListener('input', function(e) {
            var day = new Date(this.value).getUTCDay();
            if ([6, 0].includes(day)) {
                e.preventDefault();
                this.value = '';
                document.getElementById('dateErrors').style.display = "";
            }
        });

    </script>
@endsection
