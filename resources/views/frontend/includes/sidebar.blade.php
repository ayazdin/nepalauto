<div class="col-sm-3">
    @if(!$sidebartops->isEmpty())
        @foreach($sidebartops as $sidebartop)


        <div class="side-ads">
            <img src="{{url($sidebartop->image)}}" alt="{{$sidebartop->title}}">
        </div>
        @endforeach
    @endif

    <?php
            $allmetas = '';
        foreach ($epapers as $epaper) {

            $allmetas =  App\Http\Controllers\Frontend\FrontendController::getEpaperMetas($epaper->id);

            $month = $allmetas['month'];
            $year = $allmetas['years'];
            $file = $allmetas['file'];

            if(!empty($epaper->image))
                $epaperimage = $epaper->image;
            else
                $epaperimage = 'frontend/images/image-not-found.png';
            ?>
            <div class="epaperBlock">

                <div class="epaperimage">
                    <a href="{{url('/epaper/view/'.$epaper->clean_url)}}" target="_blank">
                        <img src="{{ URL::to($epaperimage) }}" alt="<?php echo $epaper->title ;?>">
                    </a>
                </div>
                <div class="detail">
                    <a href="{{url('/epaper/view/'.$epaper->clean_url)}}" target="_blank">
                    <div class="title"><?php echo $epaper->title ;?></div>
                    <div class="date"><?php echo $month.' / '.$year ;?></div>
                    </a>
                </div>

            </div>

        <?php }
    ?>
    

    @if(!$editorChoices->isEmpty())
        <div class="side-ads mar-v-20">
            <h2>लोकप्रिय</h2>
            <div class="widget">

                <ul>
                    @foreach($editorChoices as $ec)
                        <li><span><?php echo date("Y-m-d", strtotime($ec->created_at));?></span> 
                            <h3><a href="{{ URL::to($ec->clean_url) }}">{{$ec->title}}</a></h3></li>
                    @endforeach

                </ul>
            </div>
        </div>
    @endif
@if(!$sidebarbottoms->isEmpty())
        @foreach($sidebarbottoms as $sidebarbottom)


        <div class="side-ads">
            <img src="{{url($sidebarbottom->image)}}" alt="{{$sidebarbottom->title}}">
        </div>
        @endforeach
    @endif

    <!-- <div class="side-ads">
        <div class="fb-page" data-href="https://www.facebook.com/nepalauto1/" data-tabs="timeline"
         data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
         data-show-facepile="true">
        <blockquote cite="https://www.facebook.com/nepalauto1/" class="fb-xfbml-parse-ignore"><a
                href="https://www.facebook.com/nepalauto1/">Nepal Auto</a></blockquote>
         </div>
    </div>
</div> -->