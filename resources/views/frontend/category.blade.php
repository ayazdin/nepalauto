@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | '.$title)

@section('content')

    <div class="col-sm-9">
        <div class="mar-bot-40">

            <div class="row mar-bot-30 featured categorypage">
                <div class="block-ttl auto-search col-sm-12"><h2><span> {{$title}}</span> <hr></h2></div>
                @if(!$catproducts->isEmpty())
                    <div class="col-sm-12">
                        @foreach($catproducts as $result)
                            <div class="wrap ">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="f-top">
                                          
                                            <a href="{{ URL::to($result->clean_url) }}" title="{{ $result->title }}">
                                                <div class="ima" style="background-image:url({{ URL::to($result->image) }})"></div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="f-right">
                                            <h3>
                                                <a href="{{ URL::to($result->clean_url) }}" title="{{ $result->title }}">
                                                {{ $result->title }}
                                                </a>
                                            </h3>
                                            @if($result->excerpt!="")
                                              {{ str_limit($result->excerpt,250)  }}
                                            @else
                                              {{ str_limit(strip_tags($result->content),250)  }}
                                            @endif

                                            <!-- <a href="{{ URL::to($result->clean_url) }}" class="btn btn-more home-btn">
                                                 पुरा पढ्नुहोस ...
                                            </a> -->
                                        </div>
                                </div>
                                </div>
                            </div>

                        @endforeach

                        <div class="col-md-12">
                            <div class="box box-default box-solid">
                                <div class="box-body">
                                    {{ $catproducts->links('frontend.partials.paginators') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    No resutls
                @endif
            </div>

        </div>
    </div>

@endsection
