@extends ('layouts.layout')

@section ('content')

<h1 align="center">Sushi Menu</h1>

<hr>

<table cellpadding="20">

<h1 align="center">Sushi Rolls</h1>
	
<tr><td><img src="/images/salmonRoll.jpg" width="250px" height="200px"></td><td style="font-size: 30px">Salmon Roll</td><td style="font-size: 20px"><input type="hidden" name="salmonRollPrice" id="salmonRollPrice" value="10">Price: $10 (6 Rolls)</td></tr>

<tr><td><img src="/images/tunaRoll.jpg" width="250px" height="200px"></td><td style="font-size: 30px">Tuna Roll</td><td style="font-size: 20px"><input type="hidden" name="tunaRollPrice" id="tunaRollPrice" value="8">Price: $8 (6 Rolls)</td></tr>

<tr><td><img src="/images/crabRoll.jpg" width="250px" height="200px"></td><td style="font-size: 30px">Crab Roll</td><td style="font-size: 20px"><input type="hidden" name="crabRollPrice" id="crabRollPrice" value="9">Price: $9 (6 Rolls)</td></tr>

</table>

@endsection