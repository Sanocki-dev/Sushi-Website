@extends ('layouts.layout')

@section('content')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $("#pricing").click(function() {
                $("#price").val($('#quantity').attr('name'));
            });
        });

        function myFunction(index) {
            document.cookie = 'open=' + index + ';';
        }

        window.addEventListener('scroll', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        }, false);

        window.addEventListener('load', function() {
            var cookie = document.cookie.split(';');
            var cookiePair = cookie[1].split("=");
            var place = "#collapse" + cookie[1].substr(6, 1);

            $(place).addClass('show');

            if (localStorage.getItem('scrollPosition') !== null)
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
        }, false);

    </script>


    <div class="float-right" style="position: sticky; top: 0;  width: 25%">
        <div
            style="background-color: rgba(29, 29, 29, 0.657); width: 75%;font-size: 18pt; color:white; font-weight:bold; text-align:center">
            <label for="price" class="p-2" style="width: 100%; margin-bottom:-10px">Order Summary</label>
            <hr style="height: 2px; background-color:orange">
            @if (Session::has('cart'))
                @foreach ($items as $item)
                    <form action="{{ route('order.destroy', ['id' => $item['item']['menu_id']]) }}" method="post"
                        style="display: inline; text-left">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <p style="font-size: 10pt; font-weight:normal"><span
                                style="font-weight: bold; color:orange">{{ $item['qty'] }}x</span>
                            {{ $item['item']['name'] }}
                            <button type="submit"
                                style="font-size:14px; background:none; border:none; color:rgb(0, 159, 170)">Remove</button>
                        </p>
                    </form>
                @endforeach
            @endif
            <hr style="height: 2px; background-color:orange">
            <label id="price" name="price" style=" width: 100%; text-align:center; font-size: 15pt; color:orange">Total:
                ${{ Session::has('cart') ? number_format(Session::get('cart')->totalSum, 2) : '' }}</label>
            <a href="orderSummary/" class="btn"
                style="width:100%; background-color:orange; color:white; font-weight:bold">Place Order</a>
        </div>
    </div>

    <div class="accordion mb-5" id="accordion">
        <div style="color: white; margin:auto;" class="w-75 p-5">
            <h1 class="display-2 text-left pb-3">Our Menu</h1>
            @foreach ($sectionIDS as $sectionID)
                <div>
                    <div class="card-header w-75" id="heading{{ $sectionID->section_id }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#collapse{{ $sectionID->section_id }}" aria-expanded="false"
                                aria-controls="collapse{{ $sectionID->section_id }}" data-parent="#accordion"
                                style="font-size: 20pt; font-weight: bold; color: orange"
                                onclick="myFunction({{ $sectionID->section_id }})">
                                {{ $sectionID->name }}
                            </button>
                        </h2>
                    </div>
                </div>
                <div id="collapse{{ $sectionID->section_id }}" class="collapse" style=" width:75%"
                    aria-labelledby="heading{{ $sectionID->section_id }}" data-parent="#accordion">
                    <div class="card-body pl-2 ml-50" style="background-color:rgba(43, 43, 43, 0.7)">
                        @foreach ($menuIDS as $menuID)
                            @if ($menuID->section_id == $sectionID->section_id)
                                <div class="row w-100">
                                    <div class="col w-75 p-2">
                                        <label type="text" id="name" value="name"
                                            style="margin-top:0px; font-weight:bold; font-size:20pt; padding-left:5%">{{ $menuID->name }}</label>
                                    </div>
                                    <div class="col-md-auto w-25 text-right">
                                        <p style="font-size: 15pt; margin-top:10px; font-weight:bold; font-size:20pt"
                                            name="price" id="price" value="price">
                                            ${{ $menuID->price }}
                                            <a href="add-to-cart/{{ $menuID->menu_id }}" role="button"
                                                class="btn btn-primary" style="background-color:orange; border:none">Add</a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                </table>
            @endforeach
        </div>
    </div>
@endsection
