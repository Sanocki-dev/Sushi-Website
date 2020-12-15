@extends ('layouts.layout')

@section('content')
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
           
            <button type="submit" class="btn btn-primary mt-4"
                style="background-color:orange; border:none; font-weight:bold">Submit</button>
        </form>
    </div>
@endsection
