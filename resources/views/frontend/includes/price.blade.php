<div class="row mar-bot-30 price-list">
  <div class="block-ttl auto-search col-sm-12"><h2><span>मूल्य सूची खोज्नुहोस</span> <hr></h2></div>
  <div class="col-sm-12">
    <form class="needs-validation"  method="get" action="{{route('frontend.searchpricelist')}}">
      <div class="row">
        <div class="col-md-4">
          {{--<input type="text" class="form-control" name="company" id="company" placeholder="कम्पनी" value="" >--}}

          <select name="company" id="position" class="form-control select2-single">

            <option value=""></option>
            @foreach($brands as $brand)

              <option value="{{$brand->id }}"
                      @if(app('request')->input('company')==$brand->id)
                      selected
                      @endif
                      >{{$brand->title }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control" name="keywords" id="model" placeholder="खोजशब्द" value="{{app('request')->input('keywords')}}" >
        </div>
        <div class="col-md-4">
          <button class="btn btn-more" type="submit">खोज्नुहोस</button>
        </div>
      </div>
    </form>
  </div>
</div>
