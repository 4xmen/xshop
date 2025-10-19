<section class='ProductGridHiddenSidebar live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}

            <div class="btn btn-dark" id="filter-btn-show" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                 data-bs-title="{{__("Sort & filter")}}">
                <i class="ri-sort-desc"></i>
            </div>
        </h1>

        <div id="hidden-sidebar">
            @include('segments.products_page.ProductGridHiddenSidebar.inc.product-sidebar-filter')
        </div>

        <div class="py-3">
            <div class="row" id="list-row">
                @foreach($products as $product)
                    <div class="{{getSetting('grid-class')}}">
                        @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                    </div>
                @endforeach
            </div>
            @include('website.inc.website-lazy-pagination',['items' => $products])

        </div>
    </div>
</section>
