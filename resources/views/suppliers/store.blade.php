@extends ('layouts.layout')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin: auto;background-color:rgba(43, 43, 43, 0.7)" class="w-75 text-white p-5">
      <h3 class="display-2 text-white">Edit Item</h3>
      <hr style="height: 2px; background-color:orange">
        <form method="POST" class="p-5">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="Name">Supplier Name</label>
                {{-- <input type="text" class="form-control" id="name" name="name" value="{{ $menu_item->name }}"> --}}
            </div>

            <button type="submit" style="background-color:orange; color:white"  class="btn">Make Changes</button>
            <input type="button" style="background-color:orange; color:white" class="btn" value="Return to Menu" onclick="history.back()">
        </form>
    </div>

@endsection
