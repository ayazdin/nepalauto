<section class="subscribe">
    <div class="subs-box clearfix">
        <div class="container">
            @if (\Session::has('subsucc'))
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Subscription</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {!! \Session::get('subsucc') !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            <div class="row">
                <form name="frmSubscribe" class="form-control no-pad" method="post" action="{{URL::to('/subscriber')}}">
                    {!! csrf_field() !!}
                    <div class="subs-box">
                        <h3>Subscribe Now</h3>
                        <div class="subs-form">
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="subsEmail" value="">
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary btn-more" name="btnSubmit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<section class="footer">

    <div class="top-footer clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="comapany-info">
                        <h4>नेपाल अटो</h4>
                        <p>Nepal Auto is the leading online source of news about the Nepal automotive industry.
                          whatever your driving culture/Lifestyle is.
                          We are your local, one-stop site for auto information and news.
                          That’s why we’ve started our online portal that everyone can easily browse
                          everywhere online and stay updated with Auto News in Nepal.</p>
                        <ul class="lnk">
                            <li>
                              <a href="https://www.facebook.com/nepalauto1/" target="_blank">
                                <span class="social"><img src="{{url('/frontend/images/facebook.png')}}" alt="Facebook"></span>
                              </a>
                            </li>
                            <li>
                              <a href="https://twitter.com/nepal_auto" target="_blank">
                                <span class="social"><img src="{{url('/frontend/images/twitter.png')}}" alt="Twitter"></span>
                              </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="comapany-info">
                        <h4>द्रुत लिङ्कहरू</h4>
                        <ul>
                          <li><a href="{{ url('/') }}">गृहपृष्‍ठ</a></li>
                          <li><a href="{{URL::to('/category/news')}}">समाचार</a></li>
                          <li><a href="{{URL::to('/about-us')}}">हाम्रोबारे</a></li>
                          <li><a href="{{URL::to('/contact-us')}}">सम्पर्क राख्नु</a></li>
                          <li><a href="{{URL::to('/epaper/list')}}">ई-पेपर </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="comapany-info">
                      <div class="row">

                        <div class="col-sm-6">
                          <h4>समाचार</h4>
                          <ul>
                            <li><a href="{{URL::to('/category/automobile')}}">अटोमोबाइल</a></li>
                            <li><a href="{{URL::to('/category/news')}}">समाचार</a></li>
                            <li><a href="{{URL::to('/category/event')}}">इभेन्ट</a></li>
                            <li><a href="{{URL::to('/category/international')}}">अन्तर्राष्ट्रिय</a></li>
                            <li><a href="{{URL::to('/category/rochak')}}">अटो रोचक</a></li>
                            <li><a href="{{URL::to('/category/yatayat')}}">यातायात</a></li>
                            <li><a href="{{URL::to('/category/banking')}}">बैंकिङ/इन्स्योरेन्स</a></li>
                          </ul>
                        </div>
                        <div class="col-sm-6">
                          <h4>विविध </h4>
                          <ul>
                            <li><a href="{{URL::to('/category/featured')}}">फिचर</a></li>
                            <li><a href="{{URL::to('/category/interview')}}">अन्तर्वार्ता</a></li>
                            <li><a href="{{URL::to('/category/video')}}">भिडियो</a></li>
                            <li><a href="{{URL::to('/category/tips')}}">टिप्स</a></li>
                            <li><a href="{{URL::to('/category/celebrity')}}">अटो सेलिब्रेटी</a></li>
                            <li><a href="{{URL::to('/category/tech')}}">प्रविधि</a></li>
                            <li><a href="{{URL::to('/price-list')}}">मूल्य सूची</a></li>
                          </ul>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Copyright © 2014. All Rights Reserved.</h4>
                </div>
                <div class="col-sm-6">
                    <p class="pull-right"> Designed &amp; Hosted by : <a href="http://digitalagencycatmandu.com/" target="_blank"><img src="http://nepalauto.com/wp-content/themes/nepalauto-v2/images/footer-logo.png" alt="Footer Logo" class="img-responsive"> dac
                        </a></p>
                </div>
            </div>
        </div>
    </div>
</section>
