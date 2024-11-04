<section id='ProductAria' class="content">

    <div class="{{gfx()['container']}}">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{homeUrl()}}">
                        {{config('app.name')}}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{$product->category->webUrl()}}">
                        {{$product->category->name}}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{$product->name}}
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-5">
                <div id="preview">
                    <a href="{{$product->originalImageUrl()}}" id="aria-main-img" class="light-box"
                       data-gallery="aria-products">
                        <img src="{{$product->originalImageUrl()}}" alt="{{$product->name}}">
                    </a>
                </div>
                <div id="aria-img-slider">
                    @foreach($product->getMedia() as $media)
                        <div class="item">
                            <a href="{{$media->getUrl('product-image')}}">
                                <img src="{{$media->getUrl('product-image')}}" alt="{{$product->name}}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7" id="aria-product-detail">
                <a class="fav-btn" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}"
                   data-bs-custom-class="custom-tooltip"
                   data-bs-toggle="tooltip" data-bs-placement="auto" title="{{__("Add to / Remove from favorites")}}"
                >
                    <i class="ri-heart-line"></i>
                    <i class="ri-heart-fill"></i>
                </a>

                <a class="compare-btn" data-slug="{{$product->slug}}"
                   data-bs-custom-class="custom-tooltip"
                   data-bs-toggle="tooltip" data-bs-placement="auto" title="{{__("Add to/ Remove from compare list")}}">
                    <i class="ri-scales-3-line"></i>
                </a>

                <h1>
                    {{$product->name}}
                </h1>
                <div class="row">
                    <div id="price" class="col">
                        {{$product->getPrice()}}
                    </div>

                    @if($product->hasDiscount())
                        <div id="price-old" class="col">
                            {{$product->oldPrice()}}
                        </div>
                    @endif
                </div>
                <div class="description border-end-0 ps-3">
                    <p>
                        {{$product->excerpt}}
                    </p>
                </div>
                <div class="mt-4">&nbsp;</div>
                @if($product->stock_status == 'IN_STOCK')

                    @if($product->quantities()->count()>0)
                        <quantities-add-to-card
                            :qz='@json($product->quantities)'
                            :props='@json(usableProp($product->category->props))'
                            currency="{{config('app.currency.symbol')}}"
                            card-link="{{ route('client.product-card-toggle',$product->slug) }}"
                            :translate='@json(['add-to-card' => __('Add to card')])'
                            @if($product->hasDiscount())
                                :discount='@json($product->activeDiscounts()->first())'
                            @endif
                        ></quantities-add-to-card>
                    @else
                        <a href="{{ route('client.product-card-toggle',$product->slug) }}"
                           class="btn btn-outline-primary add-to-card btn-lg">
                            <i class="ri-shopping-bag-3-line"></i>
                            {{__("Add to card")}}
                        </a>
                    @endif

                @else
                    <a
                        class="btn btn-primary disabled">
                        <i class="ri-shopping-bag-3-line"></i>
                        {{__("Not available")}}
                    </a>
                @endif
                <div class="mt-4">&nbsp;</div>
                @if($product->sku != null && $product->sku != '')
                    <div class="aria-product-data">

                    <span>
                        {{__("SKU")}}:
                    </span>
                        <b>
                            {{$product->sku}}
                        </b>
                    </div>
                @endif
                @if($product->categories()->count() > 0)
                    <div class="aria-product-data">
                    <span>
                        {{__("Categories")}}:
                    </span>
                        @foreach($product->categories()->where('id','<>',$product->category->id)->get() as $cat)
                            <a href="{{$cat->webUrl()}}">
                                {{$cat->name}},
                            </a>
                        @endforeach
                        <a href="{{$product->category->webUrl()}}">
                            {{$product->category->name}}
                        </a>
                    </div>
                @endif
                @if($product->tags()->count() > 0)
                    <div class="aria-product-data">
                    <span>
                        {{__("Tags")}}:
                    </span>
                        @foreach($product->tags as $tag)
                            <a href="{{tagUrl($tag->slug)}}" class="tag me-2">
                                <i class="ri-price-tag-line"></i>
                                {{$tag->name}}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="accordion mt-4" id="product-detail">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#desc"
                            aria-expanded="true"
                            aria-controls="desc">
                        {{__("Description")}}
                    </button>
                </h2>
                <div id="desc" class="accordion-collapse collapse show" data-bs-parent="#product-detail">
                    <div class="accordion-body">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
            @if($product->table != null || trim($product->table) != '')

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#table"
                                aria-expanded="false" aria-controls="table">
                            {{__("Product table")}}
                        </button>
                    </h2>
                    <div id="table" class="accordion-collapse collapse" data-bs-parent="#product-detail">
                        <div class="accordion-body">
                            {!! $product->table !!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#info" aria-expanded="false" aria-controls="info">
                        {{__("Information")}}
                    </button>
                </h2>
                <div id="info" class="accordion-collapse collapse" data-bs-parent="#product-detail">
                    <div class="accordion-body">
                        <table class="table table-striped table-bordered table-striped">
                            <tr>
                                <th class="w-50">
                                    {{__("Item")}}
                                </th>
                                <th>
                                    {{__("Value")}}
                                </th>
                            </tr>
                            @foreach($product->fullMeta() as $meta)
                                <tr>
                                    <td>
                                        <i class="{{$meta['data']->icon}}"></i>
                                        &nbsp;
                                        {{$meta['data']->label}}
                                    </td>
                                    <td class="text-center">
                                        {!! $meta['human_value'] !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mt-4">
            {{__("Related products")}}
        </h3>
        <div id="rel-products" class="mb-2">
            @foreach($product->category->products()->where('status',1)->limit(10)->get() as $p)
                @foreach($product->category->products()->where('status',1)->limit(10)->get() as $p)
                    <div class="item">
                        @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),['$product' => $p])
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
    <div id="hidden-images">
        @foreach($product->getMedia() as $k => $media)
            <a href="{{$media->getUrl()}}" class="light-box"
               data-gallery="aria-products">
                <img src="{{$media->getUrl('product-image')}}" id="hidden-img-{{$k}}"
                     alt="{{$product->name}}">
            </a>
        @endforeach
    </div>
</section>
