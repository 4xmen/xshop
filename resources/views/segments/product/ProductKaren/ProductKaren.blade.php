<section id='ProductKaren' class="content">

    <div class="{{gfx()['container']}}">
        @include('components.err')
        <div class="row">
            <div class="col-lg-5">
                <div id="preview">
                    <a href="{{$product->originalImageUrl()}}" id="karen-main-img" class="light-box"
                       data-gallery="karen-products">
                        <img src="{{$product->originalImageUrl()}}" alt="{{$product->name}}" >
                    </a>
                </div>
                <div id="karen-img-slider">
                    @foreach($product->getMedia() as $media)
                        <div class="item">
                            <a href="{{$media->getUrl('product-image')}}">
                                <img src="{{$media->getUrl('product-image')}}" alt="{{$product->name}}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7" id="karen-product-detail">
                <nav aria-label="breadcrumb" class="pt-1">
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


                <h1>
                    {{$product->name}}
                </h1>
                <div class="description">
                    <p>
                        {{$product->excerpt}}
                    </p>
                </div>
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
                @if($product->sku != null && $product->sku != '')
                    <div class="karen-product-data">

                    <span>
                        {{__("SKU")}}:
                    </span>
                        <b>
                            {{$product->sku}}
                        </b>
                    </div>
                @endif
                @if($product->categories()->count() > 0)
                    <div class="karen-product-data">
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
                    <div class="karen-product-data">
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
                <br>
                <a class="fav-btn" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}">
                    <i class="ri-heart-line me-3"></i>
                    <i class="ri-heart-fill me-3"></i>
                    {{__("Toggle favorite")}}
                </a>

                <a class="mx-2 compare-btn" data-slug="{{$product->slug}}">
                    <i class="ri-scales-3-line me-3"></i>
                    {{__("Add to compare list")}}
                </a>
                <div class="mt-1">&nbsp;</div>

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
            </div>
        </div>
        <div class="navtabs">
            <div class="navtab active" data-target="desc">
                {{__("Description")}}
            </div>
            @if($product->table != null || trim($product->table) != '')
                <div class="navtab" data-target="table">
                    {{__("Product table")}}
                </div>
            @endif
            <div class="navtab" data-target="info">
                {{__("Information")}}
            </div>
            @if(auth('customer')->check())
                <div class="navtab" data-target="rate">
                    {{__("Rate")}}
                </div>
            @endif
            <div class="underline"></div>
        </div>
        <div id="desc" class="tab-content active">
            {!! $product->description !!}
        </div>
        <div id="table" class="tab-content">
            {!! $product->table !!}
        </div>
        <div id="rate" class="tab-content">
            <form id="rating-form" method="post" data-url="{{route('client.rate')}}">
                @csrf
                <input type="hidden" name="rateable_id" value="{{$product->id}}">
                <input type="hidden" name="rateable_type" value="{{\App\Models\Product::class}}">
                @foreach($product->evaluations() as $e)
                    <rate-input xtitle="{{$e->title}}" xname="rate[{{ $e->id }}]" :xvalue="{{detectRateCustomer(\App\Models\Product::class,$product->id,$e->id)}}"></rate-input>
                    <hr>
                @endforeach
                    <button class="btn btn-primary w-100">
                        <i class="ri-send-plane-line"></i>
                    </button>
            </form>
        </div>
        <div id="info" class="tab-content">
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
        <h3 class="mt-4">
            {{__("Related products")}}
        </h3>
        <div id="rel-products" class="mb-2">
            @foreach($product->category->products()->where('status',1)->limit(10)->get() as $p)
                <div class="item">
                @include(\App\Models\Area::where('name','product-grid')->first()->defPart(),['$product' => $p])
                </div>
            @endforeach
        </div>
    </div>
    <div id="hidden-images">
        @foreach($product->getMedia() as $k => $media)
            <a href="{{$media->getUrl()}}" class="light-box"
               data-gallery="karen-products">
                <img src="{{$media->getUrl('product-image')}}" id="hidden-img-{{$k}}"
                     alt="{{$product->name}}">
            </a>
        @endforeach
    </div>
</section>
