@if(!$nadas->isEmpty())
<div class="row mar-bot-30 featured">
    <div id="nadas" class="col-sm-12">
    
        @foreach($nadas as $nada)
            <div class="row nadalist">
                <div class="col-md-3">
                    <div class="nadahead">नाडा विशेष:</div>
                </div>
                <div class="col-md-9">
                    <div class="nadatitle">  
                        <a href="{{ URL::to($nada->clean_url) }}" title="{{$nada->title}}">{{$nada->title}}
                        </a>
                    </div>
                </div>
            </div>     
        @endforeach
    </div>
</div>
@endif
