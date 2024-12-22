<section class='ProductsSlider live-setting' data-live='{{$data->area_name.'_'.$data->part}}' >
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($part->area_name . '_' . $part->part.'_title')}}
        </h1>

        <div class="products-slider">
            @foreach(getProductsQueryBySetting($part->area_name . '_' . $part->part.'_query') as $product)
                <div class="slider-content">
                    @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                </div>
            @endforeach
        </div>
    </div>
</section>
