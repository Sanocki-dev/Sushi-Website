@extends ('layouts.layout')

@section('head.extras')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

    <script>
        function myFunction(index) {
            $('#promoCode').val(index);
        }

        function savedCardInfo() {
            var info = {
                !!json_encode($credit - > toArray()) !!
            };
            if (info.length != 0) {
                var year = new Date(info[0].exp_Date).getFullYear();
                var month = new Date(info[0].exp_Date).getMonth() + 1;
                var dateFormatted = year + "-" + zeroPad(month, 2);
                document.getElementById("cc-name").value = info[0].name;
                document.getElementById("cc-number").value = info[0].number;
                document.getElementById("cc-expiration").value = dateFormatted;
                console.log(info[0].pay_id);
                document.getElementsByName("paymentMethod")[info[0].pay_id - 1].checked = true;
            } else {
                var x = document.getElementById("message");
                if (x.style.display === "none") {
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
                                        <small id="PromoCode" onclick="myFunction('{{ $promo->code }}')"
                                            class="text-success">
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
                                    <button type="submit"
                                        style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                                </form>
                            </h6>
                            <strong style="font-size: 16pt">-${{ session()->get('promotion')['item_discount'] }}</strong>
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
            <form action="{{ route('checkout.store')}}" method="POST"  id="payment-form">
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
            <h4 class="mb-3" style="color:orange">Payment Details</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cc-number">Address</label>
                    <input type="text" class="form-control" id="cc-address" name="cc-address" minlength="5" placeholder="" required>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="cc-number">City</label>
                    <input type="text" class="form-control" id="cc-city" name="cc-city" placeholder="" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cc-number">Province</label>
                    <input type="text" class="form-control" id="cc-province" name="cc-province" placeholder="" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cc-number">Postal Code</label>
                    <input type="text" class="form-control" id="cc-postal" name="cc-postal" placeholder="" required>
                </div>
            </div>
            <div class="row p-3" id="A">
                <div class="w-50">
                    <label for="cc-name">Name on card</label>
                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
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
                <button class="btn btn-lg btn-block" style="background-color:orange; color:white" id="purchase" type="submit">Complete
                    Order</button>
            </form>
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

    </script>
@endsection
