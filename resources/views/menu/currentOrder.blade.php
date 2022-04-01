@extends ('layouts.layout')

@section('content')
    <script>
        function struck(ele) {
            if (ele.value == 0) {
                ele.style = "text-decoration:line-through; list-style-type:none";
                ele.value = 1;
            } else {
                ele.style = "";
                ele.value = 0;
            }
        }

        function myFunction() {
            var x = document.getElementById("cusomterStats");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

    </script>

<div class="w-75 p-5" style="margin: auto; background-color:rgba(43, 43, 43, 0.7)">
    <a href="javascript:history.back()" class="btn btn-primary float-right" style="background-color:orange; border:none;">Back</a>
    <form action="/complete/{{ $currentOrder->order_id }}" method="POST">
            {{ csrf_field() }}
            <div class="row w-100 " style="margin: auto">
            <div class="col-md order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="display-2 text-white">Order Overview</h3>
                    <hr style="height: 2px; background-color:orange">
                </h4>


                    <ul class="list-group mb-3">
                        @foreach ($orders as $item)
                            <li class="list-group-item d-flex justify-content-between lh-condensed" value="0"
                                onclick="struck(this)">
                                <div>
                                    <h6 class="my-0">{{ $item->quantity }}x {{ $item->menuItem->name }}</h6>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn w-100 mb-3" style="background-color:rgba(43, 43, 43, 0.7); border:1px solid white; color:white" onclick="myFunction()">Customer Info & Promotions</button>
            <div style="display: none" id="cusomterStats" class="container w-100">
                <div class="row">
                    <div class="col">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span style="font-size: 30pt; color:white; font-weight: lighter">Customer Favourites</span>
                        </h4>
                        @php
                        $count = 0;
                        $number = 0;
                        @endphp
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Most Frequently Ordered </h6>
                                    <small><strong class="text-danger">0%-50%</strong> <strong
                                            class="text-primary">50%-75%</strong>
                                        <strong class="text-success">75%-100%</strong></small>
                                </div>
                            </li>
                            @foreach ($customerStats as $stats)
                                @php
                                $percent = number_format($stats['percent'], 2)*100;
                                @endphp
                                <li class="list-group-item">
                                    <div class="w-100">
                                        <h6 class="my-0">
                                            @if ($percent < 50)
                                                <strong class="text-danger">
                                                @elseif ($percent < 75) <strong class="text-primary">
                                                    @else
                                                        <strong class="text-success">
                                            @endif
                                            {{ $percent }}%</strong> {{ $menu[$stats['item'] - 1]->name }}
                                            <input type="checkbox" class="float-right" id="promocodes" name="promos[]"
                                                value="{{ $stats['item'] }}">
                                        </h6>
                                        @php
                                        $number++;
                                        @endphp
                                        @if ($number == 5 || $number == count($customerStats))
                                            @break
                                        @endif
                            @endforeach
                            </li>
                        </ul>
                    </div>

                    <div class="col">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span style="font-size: 30pt; color:white; font-weight: lighter">Promotions</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Details</h6>
                                    <small>Give a promo for their next order!</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="row">
                                    <div class="col">
                                        <label for="startdate">Start date</label>
                                        <input type="date" class="form-control" name="startdate">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="row">
                                    <div class="col">
                                        <label for="enddate">Expiry date</label>
                                        <input type="date" class="form-control" name="enddate">
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div class="row">
                                    <div class="col">
                                        <label for="date">Discount Percentage</label>
                                        <input type="number" class="form-control" name="Discount" placeholder="Discount">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background-color:orange; border:none; font-size:30pt">Complete Order</button>
        </form>
    </div>
@endsection
