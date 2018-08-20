@if(!$featuredNews->isEmpty())
    <div class="row mar-bot-30 featured">
        <div class="block-ttl auto-search col-sm-12"><h2><span>ताजा समाचार</span> <hr></h2></div>
        @forelse ($featuredNews as $fn)
            <div class="col-sm-4">
                <div class="wrap">
                    <?php
                        if(!empty($fn->image))
                            $featimage = $fn->image;
                        else
                            $featimage = 'frontend/images/image-not-found.png';
                        ?>
                    <div class="f-top">
                        <a href="{{ URL::to($fn->clean_url) }}" title="{{ $fn->title }}">
                            <div class="ima" style="background-image:url('{{ URL::to($featimage) }}')"></div>
                        </a>
                    </div>
                    <div class="f-right">
                        <h3>
                             <a href="{{ URL::to($fn->clean_url) }}" title="{{ $fn->title }}">
                                {{ $fn->title }}
                             </a>
                        </h3>
                        {{ str_limit(strip_tags($fn->content),80)  }}
                        <!-- <a href="{{ URL::to($fn->clean_url) }}" class="btn btn-more home-btn">
                            पुरा पढ्नुहोस् ...
                        </a> -->
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@endif
