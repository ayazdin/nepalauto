<div class="row mar-bot-30 featured">
  <div class="block-ttl auto-search col-sm-12">
    <h2><span>अन्य समाचार</span> <hr></h2>
  </div>
    <div id="othernews" class="row">
        @foreach($others as $order)
            <div class="col-sm-6">
                <div class="wrap o-hight">
                    <?php
                    if(!empty($order->image))
                        $orderimage = $order->image;
                    else
                        $orderimage = 'frontend/images/image-not-found.png';
                    ?>
                    <div class="o-left">
                        <a href="{{ URL::to($order->clean_url) }}" title="{{$order->title}}">
                            <div class="ima" style="background-image:url('{{ URL::to($orderimage) }}')"></div>
                        </a>

                    </div>
                    <div class="o-right">
                        <h3>
                            <a href="{{ URL::to($order->clean_url) }}" title="{{$order->title}}">
                                {{$order->title}}
                            </a>
                        </h3>
                        @if($order->excerpt!="")
                        <p>{{ str_limit($order->excerpt,80)  }}</p>
                        @else
                        <p>{{ str_limit(strip_tags($order->content),80)}}</p>
                        @endif
                        <!-- <a href="{{ URL::to($order->clean_url) }}" class="btn btn-more home-btn">
                            पुरा पढ्नुहोस् ...
                        </a> -->
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        @endforeach

        <div id="remove-row" class="col-sm-12">
            <button id="btn-more" data-id="15" class="btn btn-more"> Load More </button>
        </div>
    </div>



</div>
