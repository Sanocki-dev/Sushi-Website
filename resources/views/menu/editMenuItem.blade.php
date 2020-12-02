@extends ('layouts.layout')

@section ('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="Name">Item Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $menu_item->name }}">
    </div>
    
    <div class="form-group">
      <label for="Section">Section</label>
      <select id="section" name="section">
          @foreach ($sections as $sec)
            <option value="{{ $sec->section_ID }}" {{ $menu_item->section_ID === $sec->section_ID ? "selected" : "" }}>{{ $sec->name }} </option>
          @endforeach
      </select>
      <hr>
      <label for="Price">Price</label>
      <input type="text" class="form-control" id="price" name="price" aria-describedby="price" value="{{ $menu_item->price }}">
    </div>
    <button type="submit" class="btn btn-primary">Make Changes</button>
    <input type="button" class="btn btn-primary" value="Return to Menu" onclick="history.back()">
  </form>

@endsection