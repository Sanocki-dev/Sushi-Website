@extends ('layouts.layout')

@section('content')

    <div class="imageShowcase">
        <img src="http://www.hicksonsizakaya.com.au/site/wp-content/uploads/2017/03/5B5A1840-min-min.jpg"
            alt="Featured Sushi" style="width: 100%;filter: brightness(60%);">
        <div class="centeredImage">
            <img class="ImageText" src="/images/SushiBaiKiyoshiTextLogo.png" alt="Sushi Bai Kiyoshi">
            {{-- <h1 class="ImageText" style="color: white; font-weight:bolder; font-size: 72pt">Sushi Bai <span
                    style="color: orange">Kiyoshi</span></h1> --}}
        </div>
    </div>
    <div class="w-100">
        <div class="container w-100" style="margin: 0ps; padding:0px">
            <div style="margin: 0ps; padding:0px; background-color:rgba(43, 43, 43, 0.7)">
                <div class="jumbotron w-75" style="margin: auto; background: none; color: white">
                    <h1 class="display-4">Welcome!</h1>
                    <hr style="background-color:orange; height:2px">
                    <p class="lead">If authenticity is what you want,then you've found it! Sushi Bai Kiyoshi is the place to
                        be. Located at the north end of Simcoe Street in the financial district of downtown Toronto.</p>
                </div>
            </div>
            <div class="container marketing" style="margin-top:30px">

                <!-- Three columns of text below the carousel -->
                <div class="row">
                    <div class="col-lg-4">
                        <img class="rounded-circle" style="height:300px; width:300px; margin-bottom:30px"
                            src="https://images.unsplash.com/photo-1563612116625-3012372fccce?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=680&q=80"
                            alt="Generic placeholder image" width="140" height="140">
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img class="rounded-circle" style="height:300px; width:300px; margin-bottom:30px"
                            src="https://images.unsplash.com/photo-1553621042-f6e147245754?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1225&q=80"
                            alt="Generic placeholder image" width="140" height="140">
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <img class="rounded-circle" style="height:300px; width:300px; margin-bottom:30px"
                            src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Generic placeholder image" width="140" height="140">
                    </div><!-- /.col-lg-4 -->
                </div><!-- /.row -->


            </div><!-- /.container -->
            <div style="margin: 0ps; padding:0px; background-color:rgba(43, 43, 43, 0.7)">
                <div class="jumbotron w-75" style="margin: auto; background: none; color: white">
                    <h1 class="display-4 text-right">About Us</h1>
                    <hr style="background-color:orange; height:2px">
                    <p class="lead">Sushi Bai kiyoshi is a family run take-out restaurant that strives to deliever its
                        customers the best quality sushi for the best prices. Kiyoshi himself purchases the fish fresh every
                        morning to ensure the best tasting best quality sushi.</p>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
