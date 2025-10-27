<section class="RandomProductsSlider live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">
        <h2 class="pt-5 pb-3">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h2>
        <div class="random-slider">
            @foreach(\App\Models\Product::where('status',1)->limit(getSetting($data->area_name.'_'.$data->part.'_limit'))->get() as $product)
                <div class="item slider-content">
                    <a href="{{$product->webUrl()}}">
                        <img src="{{$product->imgUrl()}}" alt="{{$product->name}}">
                        <h3>
                            {{$product->name}}
                        </h3>
                    </a>
                </div>

            @endforeach
        </div>
    </div>
</section>
