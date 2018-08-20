@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | '.$title)

@section('content')

    <div class="col-sm-9">
        <div class="mar-bot-40">

                <div class="row mar-bot-30 featured">
                    <div class="block-ttl auto-search col-sm-12"><h2><span>Search for: {{$title}}</span> <hr></h2></div>
                    @if(!$results->isEmpty())
                        <div class="row">
                        @foreach($results as $result)

                            <div class="col-sm-4">
                                <div class="wrap">
                                    <div class="f-top">
                                        <div class="ima" style="background-image:url({{ URL::to($result->image) }})"></div>
                                    </div>
                                    <div class="f-right">
                                        <h3>{{ $result->title }}</h3>
                                        {{ $result->excerpt  }}
                                        <a href="{{ URL::to($result->clean_url) }}" class="btn btn-danger home-btn">
                                            पुरा पढ्नुहोस् ...
                                        </a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        @endforeach

                                <div class="col-md-12">
                                    <div class="box box-default box-solid">
                                        <div class="box-body">
                                            {{ $results->links('frontend.partials.paginators') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else
                        no resutls
                    @endif
                </div>

        </div>
    </div>

@endsection
