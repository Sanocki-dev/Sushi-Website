@extends ('layouts.layout')

@section('content')
    @php
        $userCredit = auth()->user()->credit;
        if ($userCredit != null)        {
          $pay_id = $userCredit->pay_id;
          $date = substr($userCredit->exp_Date,0,7);
        }
        else {
          $pay_id = 0;
        } 
        @endphp
    <div class="w-75 p-5" style="margin:auto; color:white; background-color:rgba(56, 56, 56, 0.651)">
      <h1 class="display-2">Change Account Information</h1>
        <hr style="height: 2px; background-color:orange">
        <h4 class="mb-3" style="color:orange">Account Details</h4>
        <form method=POST action="/account">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="phone" class="form-control" id="phone" name="phone" value="{{ auth()->user()->phone }}">
            </div>
            <h4 class="mb-3" style="color:orange">Payment Details</h4>
            <div class="d-block my-3" id="ccformContainer">
                <div class="custom-control custom-radio">
                    <input onClick="newCardInfo()" id="credit" value="1" name="paymentMethod" type="radio"
                        class="form-check-input" {{ $pay_id === 1 ? "checked" : ""}} ?>
                        <label class="custom-control-label" for="credit">Credit card</label>
                </div>
                <div class="custom-control custom-radio">
                    <input onClick="newCardInfo()" id="debit" value="2" name="paymentMethod" type="radio"
                        class="form-check-input" {{ $pay_id === 2 ? "checked" : ""}} >
                    <label class="custom-control-label" for="debit">Debit card</label>
                </div>
                <div class="custom-control custom-radio">
                    <input onClick="newCardInfo()" id="paypal" value="3" name="paymentMethod" type="radio"
                        class="form-check-input" {{ $pay_id === 3 ? "checked" : ""}} >
                    <label class="custom-control-label" for="paypal">PayPal</label>
                </div>
            </div>
            <div class="row" id="A">
                <div class="col-md-6 mb-3">
                    <label for="cc-name">Name on card</label>
                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" value="{{ $userCredit != null ? $userCredit->name : ""}}" >
                    <small>Full name as displayed on card</small>
                    <div class="invalid-feedback">
                        Name on card is required
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cc-number">Credit card number</label>
                    <input type="text" class="form-control" id="cc-number" name="cc-number" minlength="16" maxlength="16"
                        placeholder="" value="{{ $userCredit != null ? $userCredit->number : ""}}" >
                    <div class="invalid-feedback">
                        Credit card number is required
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="cc-expiration">Expiration</label>
                    <input type="month" class="form-control" id="cc-expiration" name="cc-expiration" value="{{ $userCredit != null ? $date : ""}}" >
                    <div class="invalid-feedback">
                        Expiration date required
                    </div>
                </div>
            </div>
            <div class="row">
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
            <button type="submit" class="btn btn-primary mt-4"
                style="background-color:orange; border:none; font-weight:bold">Submit</button>
        </form>
    </div>
@endsection
