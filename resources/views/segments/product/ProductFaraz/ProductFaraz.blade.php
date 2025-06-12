<section class="ProductFaraz live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <nav aria-label="breadcrumb" class="py-3">
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

        <div class="row pt-2">
            <div class="col-lg-9 px-0">
                <div class="faraz-box faraz-detail">
                    <a href="{{$product->imgUrl()}}" class="light-box"
                       data-gallery="faraz-products">
                        <img src="{{$product->imgUrl()}}" alt="{{$product->name}}" class="faraz-main-image float-start">
                    </a>
                    <div class="d-none">
                        @foreach($product->getMedia() as $k => $media)
                            <a href="{{$media->getUrl()}}" class="light-box"
                               data-gallery="faraz-products">
                                <img src="{{$media->getUrl('product-image')}}" id="hidden-img-{{$k}}"
                                     alt="{{$product->name}}">
                            </a>
                        @endforeach
                    </div>
                    <h1 class="py-2">
                        {{$product->name}}
                    </h1>
                    <div class="faraz-list-item">
                    <span>
                        {{__("SKU")}}:
                    </span>

                        <b>
                            {{$product->sku}}
                        </b>
                    </div>
                    <div class="faraz-list-item">
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
                    <div class="faraz-list-item">
                        <span>
                            {{__("View")}}:
                        </span>
                        <b>
                            {{number_format($product->view)}}
                        </b>
                    </div>


                    <ul class="faraz-float-btn">
                        <li>
                            <a class="fav-btn" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               data-bs-custom-class="custom-tooltip"
                               data-bs-title="{{__("Add to / Remove from favorites")}}"
                            >
                                <i class="ri-heart-line"></i>
                                <i class="ri-heart-fill"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#share-modal" class="share-btn"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               data-bs-custom-class="custom-tooltip"
                               data-bs-title=" {{__("Share")}}">
                                <i class="ri-share-line"></i>
                            </a>
                        </li>
                        <li>
                            <a class="compare-btn" data-slug="{{$product->slug}}"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               data-bs-custom-class="custom-tooltip"
                               data-bs-title=" {{__("Add to compare list")}}">
                                <i class="ri-scales-3-line"></i>
                            </a>
                        </li>
                    </ul>


                </div>
                <div class="faraz-box my-3">
                    <h3>
                      <span>
                           {{__("About")}}   {{$product->name}}
                      </span>
                    </h3>
                    <p>
                        {{$product->excerpt}}
                        <a href="#" id="faraz-more">
                            {{__("Read more")}} <i class="ri-align-justify"></i>
                        </a>
                    </p>
                    <div class="read-more">
                        {!! $product->description !!}
                    </div>

                    <h3 id="faraz-detail" class="mt-3">
                        <span>
                            {{__("Detail")}}
                        </span>
                    </h3>
                    <table class="table table-striped table-bordered table-striped">
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


                </div>
                <div class="faraz-box mb-3">

                    <h3 id="faraz-table">
                       <span>
                            {{__("Table")}}
                       </span>
                    </h3>

                    <div>
                        {!! $product->table !!}
                    </div>

                    <h3 id="faraz-comment" class="mt-3">
                        <span>
                            {{__("Comments & Rate")}}
                        </span>
                    </h3>
                    <form id="rating-form" method="post" data-url="{{route('client.rate')}}">
                        @csrf
                        <input type="hidden" name="rateable_id" value="{{$product->id}}">
                        <input type="hidden" name="rateable_type" value="{{\App\Models\Product::class}}">
                        @foreach($product->evaluations() as $e)
                            <rate-input xtitle="{{$e->title}}" xname="rate[{{ $e->id }}]"
                                        :xvalue="{{detectRateCustomer(\App\Models\Product::class,$product->id,$e->id)}}"></rate-input>
                            <hr>
                        @endforeach
                        <button class="btn btn-primary w-100">
                            <i class="ri-send-plane-line"></i>
                        </button>
                    </form>
                    @foreach($data['comments']??[] as $comment)
                        @include('segments.post.SimplePost.inc.comment-detail',$comment)
                    @endforeach
                    <h3 class="mt-3">
                        <span>
                            {{__("Post your comment")}}
                        </span>
                    </h3>
                    @include('components.err')
                    <form id="comment-form" class="safe-form" method="post">
                        <div class="safe-url" data-url="{{route('client.comment.submit')}}"></div>
                        @csrf

                        <input type="hidden" name="commentable_type" value="{{$data['commentable_type']}}">
                        <input type="hidden" name="commentable_id" value="{{$data['commentable_id']}}">
                        <input type="hidden" name="parent_id" id="parent_id">
                        <div class="row">

                            @if(auth()->check())
                                <div class="col-12">
                    <span class="comment-as">
                        {{auth()->user()->name}}
                    </span>
                                </div>
                            @elseif(auth('customer')->check())
                                <div class="col-12">
                    <span class="comment-as">
                        {{auth('customer')->user()->name}}
                    </span>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <label for="name">
                                        {{__("Name")}}
                                    </label>
                                    <input type="text" name="name" class="form-control" placeholder="{{__("Name")}}"
                                           id="name">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">
                                        {{__("Email")}}
                                    </label>
                                    <input type="email" name="email" class="form-control" placeholder="{{__("Email")}}"
                                           id="email">
                                </div>
                            @endif
                            <div class="col-12 mt-2">
                                <label>
                                    {{__("Message")}}
                                </label>
                                <textarea name="message" placeholder="{{__("Message...")}}" class="form-control"
                                          rows="3"></textarea>
                                <div class="text-center">

                                    <button class="btn btn-primary w-25 my-3  ">
                                        <i class="ri-send-plane-2-line"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 px-lg-3 p-sm-0 p-md-0">
                <div class="faraz-box">
                    <a href="#" class="faraz-rate">
                        <i class="ri-star-fill float-start mx-2"></i>
                        @if($product->rating_count)
                            {{number_format($product->average_rating,1)}} ({{$product->rating_count}})
                        @else
                            {{__("Without any rate")}}
                        @endif
                    </a>
                    <div class="my-2 text-end">

                        <h4 class="price">
                            <div id="price" class="col">
                                {{$product->getPrice()}}
                            </div>

                            @if($product->hasDiscount())
                                <div id="price-old" class="col">
                                    {{$product->oldPrice()}}
                                </div>
                            @endif
                        </h4>
                    </div>
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
                               class="btn btn-primary add-to-card d-block">
                                <i class="ri-shopping-bag-3-line"></i>
                                {{__("Add to card")}}
                            </a>
                        @endif

                    @else
                        <a
                            class="btn btn-primary disabled d-block">
                            <i class="ri-shopping-bag-3-line"></i>
                            {{__("Not available")}}
                        </a>
                    @endif
                    <hr>
                    {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
                </div>
                <a class="faraz-box my-3" href="#faraz-table">
                    <i class="ri-table-2 float-start mx-2"></i>
                    <span class="a-little-bottom">
                        {{__("Table")}}
                    </span>
                    <i class="ri-arrow-down-line float-end mx-2"></i>
                </a>
                <a class="faraz-box mb-3" href="#faraz-detail">
                    <i class="ri-information-2-line float-start mx-2"></i>
                    <span class="a-little-bottom">
                        {{__("Detail")}}
                    </span>
                    <i class="ri-arrow-down-line float-end mx-2"></i>
                </a>
                <a class="faraz-box mb-3" href="#faraz-comment">
                    <i class="ri-chat-3-line float-start mx-2"></i>
                    <span class="a-little-bottom">
                        {{__("Comments & Rate")}}
                    </span>
                    <i class="ri-arrow-down-line float-end mx-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
