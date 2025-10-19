<section class='ProductGrid content live-setting' data-live="{{$data->area_name.'_'.$data->part}}" id="product-list-view">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row" id="list-row">
            @foreach($products as $product)
                <div class="col-md-4 p-2">
                    @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                </div>
            @endforeach
        </div>
        @include('website.inc.website-lazy-pagination',['items' => $products])
    </div>
</section>
