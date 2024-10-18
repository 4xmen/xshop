<section class='ProductGridHiddenSidebar'>
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
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 p-2">
                        @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                    </div>
                @endforeach
            </div>
            {{$products->withQueryString()->links()}}

        </div>
    </div>
</section>
