<section class="PedramProducts live-setting" data-live="{{$data->area_name.'_'.$data->part}}">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
        <path fill="{{getSetting($data->area_name.'_'.$data->part.'_color_bg')}}"
              d="M194,99c186.7,0.7,305-78.3,306-97.2c1,18.9,119.3,97.9,306,97.2c114.3-0.3,194,0.3,194,0.3s0-91.7,0-100c0,0,0,0,0-0 L0,0v99.3C0,99.3,79.7,98.7,194,99z"></path>
    </svg>
    <img src="{{asset('upload/images/'.$data->area_name.'.'.$data->part.'2.png')}}" alt="[right]" class="right-img">
    <img src="{{asset('upload/images/'.$data->area_name.'.'.$data->part.'1.png')}}" alt="[left]" class="left-img">
    <div class="content">
        <div class="{{gfx()['container']}}">
            <h1>
                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
            </h1>
            <div class="content2">

                <ul class="pedi-tab-control">
                    @foreach(getCategorySubCatsBySetting($data->area_name.'_'.$data->part.'_category') as $k => $cat)
                        <li data-id=".cat{{$cat->id}}" @if($k == 0 ) class="active" @endif>
                            {{$cat->name}}
                        </li>
                    @endforeach
                </ul>

                @foreach(getCategorySubCatsBySetting($data->area_name.'_'.$data->part.'_category') as $k => $cat)
                    <div class="cat{{$cat->id}} pedi-tab mp-4 @if($k == 0 ) active @endif">
                        <div class="row">

                            @foreach($cat->products()->where('status',1)->orderByDesc('id')->limit(6)->get() as $product)
                                <div class="col-lg-6">
                                    <a class="pedi-product" href="{{$product->webUrl()}}">
                                        <img src="{{$product->thumbUrl()}}" alt="{{$product->name}}" class="float-start">
                                        <span>
                                            {{$product->getPrice()}}
                                        </span>
                                        <h4>
                                            {{$product->name}}
                                        </h4>
                                        <p>
                                            {{\Illuminate\Support\Str::limit($product->excerpt)}}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <svg
        width="1000"
        height="200"
        viewBox="0 0 1000 200"
        xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="none"
        xmlns:svg="http://www.w3.org/2000/svg">
        <path
            style="fill:{{getSetting($data->area_name.'_'.$data->part.'_color_bg')}}"
            d="M 0,0 H 1000 V 200 C 1000,200 457.30891,69.618505 188.97638,113.38583 120.58681,124.54075 0,200 0,200 Z"/>
    </svg>
</section>
