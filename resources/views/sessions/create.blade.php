@extends ('layouts.layout')

@section('content')

    <div class="w-50 mt-5  p-5" style="margin: auto;color:white; background-color:rgba(56, 56, 56, 0.651)">

        <h1 class="display-2">Sign Up</h1>
        <hr style="height: 2px; background-color:orange">
        <form method=POST action="/register" autocomplete="off">

            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" class="form-control" id="name" name="name" placeholder="Name" autocomplete="off" required value="Customer">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required value="Customer@test.com">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off" required value="9054474758">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required value="Customer">
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" class="form-control" id="Confirmpassword" name="confirmpassword" autocomplete="off" placeholder="Password"
                    required value="Customer">
            </div>
            <button type="submit" class="btn btn-primary mt-4"  style="background-color:orange; border:none; font-weight:bold">Submit</button>
        </form>
    </div>

@endsection
