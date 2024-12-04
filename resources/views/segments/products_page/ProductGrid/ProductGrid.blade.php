<section class='ProductGrid content live-setting' data-live="{{$data->area_name.'_'.$data->part}}" id="product-list-view">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 p-2">
                    @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                </div>
            @endforeach
        </div>
        {{$products->withQueryString()->links()}}
    </div>
</section>
