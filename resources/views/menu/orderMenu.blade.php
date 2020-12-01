@extends ('layouts.layout')

@section ('content')

  <script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous">
  </script>

<script>

  $(document).ready(function() {
    $("#pricing").click(function(){
      $("#price").val($('#quantity').attr('name'));
    });
  });
</script>


<form method="POST" action="/orderSummary">
  {{ csrf_field() }}
  <div class="float-right" style="position: sticky; top: 0; background-color: rgba(29, 29, 29, 0.657); width: 25%; height: 5em;">
    <label for="price" style="background-color:none; width: 100%; text-align:center; font-weight:bold; font-size: 20pt; color:white;">Total Order Price</label>
    <label type="hidden" id="price" name="price" style=" width: 100%; text-align:center; font-size: 15pt;" value=""></label>
    <button type="submit" class="btn btn-primary" style="width:100%;">Place Order</button>
  </div>
  
  <h1 align="center">Order sushi here</h1>
  
  <hr>
  
@foreach ($sectionIDS as $sectionID)
<h1 align="left" style=" padding:10px">{{ $sectionID->name }}</h1>
<hr>

<table cellpadding="20" style="margin-bottom: 20px;width: 70%;border-radius:20px; background-color:rgb(63, 63, 63)">

@foreach ($menuIDS as $menuID)

@if ($menuID->section_ID == $sectionID->section_ID)
<tr style=" color: white; ">
  <td style="font-size: 30px; width:80%;">
    <label type="text" id="name" value="name" style="margin-top:10px">{{ $menuID->name }}</label>
  </td>
  <td  style="font-size: 30px; width:10%; text-align:right;">
    <p style="font-size: 15pt;  margin-top:10px " name="price" id="price" value="price">${{ $menuID->price }}</p>
  </td>
  <td style="width:10%" id="pricing">
    <input type="number" min="0" name="amount[]" id="quantity" size="1" value="0" style="background: none; border-radius: .1em; width: 100%; font-size: 20pt; text-align: center; color: white"></td></tr>
@endif
@endforeach
</table>
@endforeach

</form>

@endsection