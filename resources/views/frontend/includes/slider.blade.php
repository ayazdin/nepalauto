<div class="row mar-bot-40">
    <div class="col-sm-8">
        <div id="imgCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
            <ol class="carousel-indicators">
                @foreach($posts as $key => $post)
                    <li data-target="#imgCarousel" data-slide-to="{{$key}}" class="@if($key=='0') active @endif"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($posts as $key => $post)
                    <div class="carousel-item @if($key=='0') active @endif">
                        <img src="{{ URL::to($post->image) }}" alt="{{$post->title}}">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#imgCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imgCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
    <div id="txtCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
      <div class="carousel-inner">
          @foreach($posts as $key => $post)
              <div class="carousel-item @if($key=='0') active @endif">
                  <div class="news-item">
                      <h2>{{$post->title}}{{--<br>--}}
                          {{--<span class="emp-text">Date: 11 June, 2018</span> <span class="emp-text">Author: Ek Raj</span>--}}
                      </h2>
                      {!! \Illuminate\Support\Str::words(strip_tags($post->content), 40,'...')  !!}
                      <?php //echo  strip_tags( $post->content );?>
                      <p><a href="{{ URL::to($post->clean_url) }}">Read more...</a></p>
                  </div>
              </div>
          @endforeach
      </div>
    </div>
  </div>
</div>
