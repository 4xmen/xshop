<section class='ProductGridSidebar content live-setting' data-live="{{$data->area_name.'_'.$data->part}}"
         id="product-list-view">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @if(!getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-lg-1 pt-lg-0">
                    @include('segments.products_page.ProductGridSidebar.inc.product-sidebar')
                </div>
            @endif
            <div class="col-lg-9">
                <div class="row" id="list-row">
                    @foreach($products as $product)
                        <div class="{{getSetting('grid-class')}}">
                            @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                        </div>
                    @endforeach
                </div>
                @include('website.inc.website-lazy-pagination',['items' => $products])

            </div>
            @if(getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3">
                    @include('segments.products_page.ProductGridSidebar.inc.product-sidebar')
                </div>
            @endif
        </div>
    </div>
</section>
