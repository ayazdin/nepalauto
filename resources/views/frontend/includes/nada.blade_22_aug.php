@if(!$nadas->isEmpty())
    <div class="row mar-bot-30 featured">
      <div class="block-ttl auto-search col-sm-12">
        <h2><span>Nada</span> <hr></h2>
      </div>
        <div id="nadas" class="row">
            
            @foreach($nadas as $nada)
                <div class="col-sm-6">
                    <div class="wrap o-hight">
                        <?php
                        if(!empty($nada->image))
                            $nadaimage = $nada->image;
                        else
                            $nadaimage = 'frontend/images/image-not-found.png';
                        ?>
                        <div class="o-left">
                            <a href="{{ URL::to($nada->clean_url) }}" title="{{$nada->title}}">
                                <div class="ima" style="background-image:url('{{ URL::to($nadaimage) }}')"></div>
                            </a>
                            
                        </div>
                        <div class="o-right">
                            <h3>
                                <a href="{{ URL::to($nada->clean_url) }}" title="{{$nada->title}}">
                                    {{$nada->title}}
                                </a>
                            </h3>

                            <p>{{ str_limit($nada->excerpt,70)  }}</p>
                            <!-- <a href="{{ URL::to($nada->clean_url) }}" class="btn btn-more home-btn">
                                पुरा पढ्नुहोस् ...
                            </a> -->
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
