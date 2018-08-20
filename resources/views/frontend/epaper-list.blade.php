@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | Epaper')

@section('content')

    <div class="col-sm-9">
        <div class="mar-bot-40">
            <div class="row mar-bot-30 featured epaperlist">
                <div class="block-ttl auto-search col-sm-12"><h2><span> Epapers</span> <hr></h2>
                </div>

                @if(!$allepaper->isEmpty())
                    @foreach($allepaper as $epaper)
                        <div class="col-sm-4">
                            <div class="wrap">
                                <?php
                                if(!empty($epaper->image))
                                    $brandimage = $epaper->image;
                                else
                                    $brandimage = 'frontend/images/image-not-found.png';
                                ?>
                                <div class="f-top">
                                    <a href="{{ URL::to('/epaper/view/'.$epaper->clean_url) }}" title="{{ $epaper->title }}" target="_blank">
                                        <div class="ima" style="background-image:url('{{ URL::to($brandimage) }}')"></div>
                                    </a>
                                </div>
                                <div class="f-right">
                                    <h3>
                                        <a href="{{ URL::to('/epaper/view/'.$epaper->clean_url) }}" title="{{ $epaper->title }}" target="_blank">
                                            {{ $epaper->title }}
                                        </a>
                                    </h3>
                                        <?php
                                            $allmetas =  App\Http\Controllers\Frontend\FrontendController::getEpaperMetas($epaper->id);
                                                $month = $allmetas['month'];
                                                $year = $allmetas['years'];
                                                $file = $allmetas['file'];

                                            echo '<p>'.$month.' / '.$year.'</p>';
                                        ?>
                                </div>
                                <div class="clear"></div>
                            </div>

                        </div>
                    @endforeach
                @else
                    No epapers
                @endif


            </div>
        </div>
    </div>





@endsection