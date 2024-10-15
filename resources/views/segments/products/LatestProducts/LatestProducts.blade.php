<section class='LatestProducts'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{__("Latest products")}}
        </h1>
        <div class="row">
            @foreach(\App\Models\Product::where('status',1)->orderByDesc('id')->limit(4)->get() as $product)
                <div class="col-lg-3 col-md-6">
                    @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),compact('product'))
                </div>
            @endforeach
        </div>
        <div class="p-4 text-center mt-2">
            <a href="{{productsUrl()}}" class="btn btn-secondary">
                {{__("All products")}}
            </a>
        </div>
    </div>
</section>
