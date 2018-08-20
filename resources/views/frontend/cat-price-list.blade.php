@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | '.$title)

@section('content')
    <div class="col-sm-9">
        <div class="mar-bot-40">
            <div class="row mar-bot-30 featured">
                <div class="block-ttl auto-search col-sm-12"><h2><span> {{$title}}</span> <hr></h2>

@include('frontend.includes.price')
                </div>
                

                @if(!$autobrands->isEmpty())
                    @foreach($autobrands as $autobran)
                        <div class="col-sm-4">
                            <div class="wrap">
                                <?php
                                if(!empty($autobran->image))
                                    $brandimage = $autobran->image;
                                else
                                    $brandimage = 'frontend/images/image-not-found.png';
                                ?>
                                <div class="f-top">
                                    <a href="{{ URL::to('price-list/'.$autobran->slug) }}" title="{{ $autobran->title }}">
                                        <div class="ima" style="background-image:url('{{ URL::to($brandimage) }}')"></div>
                                    </a>
                                    
                                </div>
                                <div class="f-right">
                                    <h3>
                                        <a href="{{ URL::to('price-list/'.$autobran->slug) }}" title="{{ $autobran->title }}">
                                         {{ $autobran->title }}
                                        </a>
                                    </h3>
                                    <div class="branddetail">{{ str_limit($autobran->content,80)  }}</div>
                                    <!-- <a href="{{ URL::to('price-list/'.$autobran->slug) }}" class="btn btn-more home-btn">
                                         पुरा पढ्नुहोस्...
                                    </a> -->
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                     @endforeach
                @endif


            </div>
        </div>
    </div>
@endsection