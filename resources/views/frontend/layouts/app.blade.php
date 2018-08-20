<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Auto Nepal">


    <title>@yield('title')</title>

    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">

    <meta property="og:site_name" content="Auto Nepal"/>
    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:description" content="@yield('description')"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="@yield('url')"/>
    <meta property="og:image" content="@yield('image')"/>


    <!-- Bootstrap core CSS -->
    <link href="{{url('/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link href="{{url('/frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{url('/frontend/css/custom.css')}}" rel="stylesheet">

<link rel="shortcut icon" type="image/png" href="{{ URL::to('photos/fav.png') }}"/>

<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-21106546-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1536813856603295&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('frontend/includes.header')



<div class="container mar-top-40">
        <div class="latest-news">
            <div class="row">
                @yield('content')

                @include('frontend.includes.sidebar')


            </div>
        </div>
    </div>







@include('frontend.includes.sub-footer')



        <!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

<script src="{{url('/frontend/js/bootstrap.min.js')}}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{url('/frontend/js/ie10-viewport-bug-workaround.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','#btn-more',function(){
            var id = $(this).data('id');
            $(this).data('id', id+4);
            $("#btn-more").html("Loading....");
            $.ajax({
                url : '{{ url("loadajax") }}',
                method : "POST",
                data : {id:id, _token:"{{csrf_token()}}"},
                dataType : "text",
                success : function (data)
                {
                    if(data != '')
                    {
                        $('#remove-row').remove();
                        $('#othernews').append(data);
                    }
                    else
                    {
                        $('#btn-more').html("No Data");
                    }
                }
            });
        });
    });

    $(window).on('load',function(){
        $('#exampleModalLong').modal('show');
    });


    $(function () {
        $('#imgCarousel').on('slide.bs.carousel', function (e) {
            console.log(e.direction);
            if(e.direction=='left')
                $('#txtCarousel').carousel('next'); // Will slide to the slide 2 as soon as the transition to slide 1 is finished
            else {
                $('#txtCarousel').carousel('prev')
            }
        })
    });

    $("#position").select2({
        allowClear:true,
        placeholder: 'कम्पनी'
    });


</script>
</body>
</html>
