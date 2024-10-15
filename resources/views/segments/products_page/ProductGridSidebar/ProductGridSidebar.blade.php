<section class='ProductGridSidebar content' id="product-list-view">
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
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 p-2">
                            @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                        </div>
                    @endforeach
                </div>
                {{$products->withQueryString()->links()}}

            </div>
            @if(getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3">
                    @include('segments.products_page.ProductGridSidebar.inc.product-sidebar')
                </div>
            @endif
        </div>
    </div>
</section>
