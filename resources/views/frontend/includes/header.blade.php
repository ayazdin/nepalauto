<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="brand-logo">
                <a class="hed-logo" href="{{ url('/') }}" title="Nepal Auto | Automotive News Nepal" rel="home">
                    <img src="{{ URL::to('photos/uploads/2017/05/logo.png') }}" alt="Nepal Auto | Automotive News Nepal" class="img-responsive">
                </a>
            </div>
        </div>
        <div class="col-sm-9 alg-rht">
            <!--<img src="{{url('/frontend/images/Gulf-Ave-trading.gif')}}" alt="Gulf Ave Trading" width="728">-->
        </div>
    </div>
</div>
<header>
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
        <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <a class="navbar-brand" href="#">Navbar</a> -->

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="{{ url('/') }}"> गृहपृष्‍ठ <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/automobile')}}">अटोमोबाइल</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/news')}}">समाचार</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/event')}}">इभेन्ट</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/international')}}">अन्तर्राष्ट्रिय</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/rochak')}}">अटो रोचक</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/yatayat')}}">यातायात</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/tech')}}">प्रविधि</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/price-list')}}">मूल्य सूची</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/epaper/list')}}">ई-पेपर </a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/category/banking')}}">बैंकिङ/इन्स्योरेन्स</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/about-us')}}">हाम्रोबारे</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{URL::to('/contact-us')}}">सम्पर्क</a>
                    </li> -->

                  </ul>
                <form action="{{ url('/') }}" method="get" class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" name="s">
                    <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
                </form>
            </div>
        </div>
    </nav>
</header>
