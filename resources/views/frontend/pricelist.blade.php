@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | Price List')

@section('content')
    <div class="col-sm-9">
        <div class="mar-bot-40">

            <div class="row mar-bot-30 featured">
                <div class="block-ttl auto-search col-sm-12"><h2><span>Price List for: {{$company}} ,Keyword :{{$keywords}}</span> <hr></h2></div>
                <div class="col-sm-12">
                     @include('frontend.includes.price')
                </div>

                @if(!$products->isEmpty())
                    <div class="col-sm-12">
                        <div class="row brandlisting">
                          <?php //print_r($products);exit; ?>
                            @foreach($products as $result)
                                <div class="col-sm-3">
                                    <div class="wrap">
                                        <div class="f-right">
                                            <div class="title">{{ $result->title }}</div>
                                            <div class="detail">{!! $result->content !!}</div>
                                            <div class="price"><span>
                                              <?php if(is_numeric($result->excerpt)){?> NRS <?php echo number_format($result->excerpt, 0,'',',');}?>
                                            </span></div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    No resutls
                @endif
            </div>

        </div>
    </div>
@endsection
