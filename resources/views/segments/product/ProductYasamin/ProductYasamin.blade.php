<section id='ProductYasamin' >
    <div class="row">
        <div class="col-lg-5">
            <div class="ps-2">
                <nav aria-label="breadcrumb" class="pt-1 my-2">
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
            </div>
            <div class="yac-product-data">
                <rate-input xtitle="{{__("Rate")}}" xname="" :xvalue="{{$product->rate}}"></rate-input>
            </div>
            @if($product->sku != null && $product->sku != '')
                <div class="yac-product-data">

                    <span>
                        {{__("SKU")}}:
                    </span>
                    <b class="float-end">
                        {{$product->sku}}
                    </b>
                </div>
            @endif
            <div class="row text-center">
                <div id="price" class="col">
                    {{$product->getPrice()}}
                </div>

                @if($product->hasDiscount())
                    <div id="price-old" class="col">
                        {{$product->oldPrice()}}
                    </div>
                @endif
            </div>
            <br>
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
            <h4>
                {{__("Description")}}
            </h4>
            <div class="p-3">
                <div class="alert alert-info">
                    {{$product->excerpt}}
                </div>
                {!! $product->description !!}

                @if($product->table != null || trim($product->table) != '')
                    {!! $product->table !!}
                @endif

                <table class="table table-striped  table-striped">
                    <tr class="text-center">
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

                @if(auth('customer')->check())
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
                @endif
            </div>


            @if($product->categories()->count() > 0)
                <div class="yac-product-data">
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
                <div class="yac-product-data">
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
        <div class="col-lg-7">
            <div id="yac-images">
                @foreach($product->getMedia() as $media)
                    <div class="item">
                        <a href="{{$media->getUrl('product-image')}}" class="light-box"
                           data-gallery="yac-products">
                            <img src="{{$media->getUrl('product-image')}}" alt="{{$product->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container-fluid">
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
    </div>
</section>
