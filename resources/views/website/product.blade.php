@extends('website.layout.layout')
@section('title')
    {{$pro->name}} -
@endsection
@section('content')
    @php
        $commentCount = $pro->comments()->count();
    @endphp
    {!! \App\Helpers\showBreadcrumb(\App\Helpers\makeProductBreadcrumb($pro,$cat)) !!}
    <script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{$pro->name}}",
  "image": "{{$pro->thumbUrl()}}",
  "description": "{{$pro->excerpt}}",
  "brand": {
    "@type": "Brand",
    "name": "{{$cat->name}}"
  },
  "sku": "{{$cat->sku}}",
  "offers": {
    "@type": "AggregateOffer",
    "url": "{{route('product',$pro->slug)}}",
    "priceCurrency": "IRR",
    "lowPrice": "{{$pro->getPrice()}}",
    "offerCount": "{{$pro->stock_quantity}}"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{$pro->average_rating}}",
    "ratingCount": "{{$pro->rating_count}}",
    "reviewCount": "{{$commentCount}}"
  },
  "review": [@foreach($pro->comments()->where('status',1)->get() as $k => $c){
    "@type": "Review",
    "name": "Comment {{$pro->name}}",
    "reviewBody": "{{$c->body}}",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "datePublished": "{{$c->created_at}}",
    "author": {"@type": "Person", "name": "{{$c->name}}"}
  }@if($k+2 < $commentCount),@endif
        @endforeach
        ]
      }

    </script>
    <div>
        <section id="product">
            <div class="container shadow corner">
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('welcome')}}">
                                {{config('app.name')}}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('products')}}">محصولات</a>
                        </li>
                        @if ($cat->parent != null)
                            <li class="breadcrumb-item">
                                <a href="{{route('cat',$cat->parent->slug)}}">{{$cat->parent->name}}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item">
                            <a href="{{route('cat',$cat->slug)}}">{{$cat->name}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$pro->name}}
                        </li>
                    </ol>
                </div>
                <div class="row" style="background: #FFFFFF">
                    <div class="col-md-5 ">

                        {{--                        <div class='zoom' id='ex1'>--}}
                        {{--                            <img src='{{$pro->imgurl()}}' width='555' height='320' alt='Daisy on the Ohoopee'/>--}}
                        {{--                        </div>--}}

                        <a href="images/image-1.jpg" data-lightbox="img-1" id="lightbx" data-title="{{$pro->title}}">
                            <img class="xzoom img-fluid" src="{{$pro->thumburl()}}" xoriginal="{{$pro->imgurl()}}"/>
                        </a>
                        <div class="xzoom-thumbs owl-carousel owl-theme" id="thumbs">
                            @foreach ($pro->getMedia() as $k => $media)
                                <a href="{{$media->getUrl('product-image')}}" class="mt-2 d-inline-block">
                                    <img alt="{{$pro->title}}" class="xzoom-gallery" width="100"
                                         src="{{$media->getUrl('product-thumb')}}">
                                </a>
                            @endforeach
                        </div>

                    </div>
                    <div class="col-md-7 detail">
                        <h1>
                            {{$pro->name}}
                        </h1>
                        <hr>

                        <h2>
                            اطلاعات محصول:
                        </h2>
                        <table class="table table-hover product-table" id="product-table">
                            <tr>
                                <th>
                                    نام محصول
                                </th>
                                <td>
                                    {{$pro->name}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    کد محصول
                                </th>
                                <td>
                                    {{$pro->getCode()}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    قیمت
                                </th>
                                <td class="main-price">
                                    <b>
                                                <span id="last-pricex">
                                                    {{$pro->getPrice()}}
                                                </span>
                                    </b>
                                </td>
                            </tr>
                            @if($pro->hasMeta('color'))
                                <tr>
                                    <th>
                                        انتخاب رنگ
                                    </th>
                                    <td>
                                        <div class="color-pick">

                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th style="vertical-align: middle">
                                    تعداد
                                </th>
                                <td>
                                    {{--                                                <div id="counting" class="text-muted float-start mt-2"></div>--}}
                                    <div class="product-count d-inline-block">
                                        <div class="btn btn-info count-inc" style="padding: 2px 5px">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <input type="number" id="single-count" class="product-count"
                                               value="1" max="1">
                                        <div class="btn btn-info count-dec" style="padding: 2px 5px">
                                            <i class="fa fa-minus"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if($pro->hasMeta('warranty'))
                                <tr>
                                    <th>
                                        گارانتی
                                    </th>
                                    <td>
                                        @php $ws = json_decode(\App\Helpers\getProp('warranty')->options,'true'); @endphp
                                        <select name="" id="" class="form-control">
                                            @foreach($ws as $w)
                                                <option value="{{$w['value']}}"> {{$w['title']}} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>
                                    امتیاز
                                </th>
                                <td>
                                    <div class="star-rating js-star-rating" dir="ltr">
                                        <input class="star-rating__input" type="radio" name="rating" value="1"><i
                                            class="star-rating__star"></i>
                                        <input class="star-rating__input" type="radio" name="rating" value="2"><i
                                            class="star-rating__star"></i>
                                        <input class="star-rating__input" type="radio" name="rating" value="3"><i
                                            class="star-rating__star"></i>
                                        <input class="star-rating__input" type="radio" name="rating" value="4"><i
                                            class="star-rating__star"></i>
                                        <input class="star-rating__input" type="radio" name="rating" value="5"><i
                                            class="star-rating__star"></i>
                                        <div
                                            class="current-rating current-rating--{{round($pro->average_rating)}} js-current-rating">
                                            <i class="star-rating__star">AAA</i></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="row mt-3">
                            <div class="col-5">
                                <a href="{{route('compare.add',$pro->slug)}}" class="btn btn-warning mt-1"
                                   data-wow-delay="1.5s"
                                   data-wow-duration="2s">
                                    <i class="fa fa-compass mt-2 mb-2"></i>
                                    &nbsp;
                                    مقایسه کالا
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{route('card.addq',['',''])}}"
                                   class="add-to-card-q btn btn-primary w-100 mt-1">
                                    <img src="{{asset('images/basket.svg')}}" class="basket-icon" alt="">
                                    افزودن به سبد خرید
                                </a>

                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <ul class="tabs cl" id="my-tabs">
                            <li class="active lc" data-content="tab-detail">مشخصات فنی</li>
                            <li class="lc" data-content="tab-analyze">تحلیل و بررسی</li>
                            <li class="lc" data-content="tab-comment"> دیدگاه کاربران</li>
                            <li class="lc" data-content="tab-question"> پرسش و پاسخ</li>
                            <li class="lc" data-content="tab-chart">نمودار قیمت</li>
                        </ul>
                        <div class="tab-container">
                            <div id="tab-detail" class="active">

                                <table class="table table-bordered attribute ">
                                    @foreach($pro->getAllMeta() as $k => $meta)
                                        @if($k != 'color' && $k != 'warranty')
                                            <tr>
                                                <td>
                                                    {{\App\Helpers\getPropLabel($k)}}
                                                </td>
                                                <td>
                                                    {!! \App\Helpers\showMeta($k,$meta) !!}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                            <div id="tab-analyze">
                                <div class="content ">
                                    {!! $pro->description !!}
                                </div>
                            </div>
                            <div id="tab-comment">
                                <!-- Contenedor Principal -->
                                <div class="comments-container">
                                    <ul id="comments-list" class="comments-list">
                                        @foreach($comments as $c)
                                            @include('starter-kit::component.comment',['c'=>$c])
                                        @endforeach
                                    </ul>
                                    {{$comments->links()}}
                                </div>
                                <div class="comments-container non-print">
                                    <div class="alert alert-secondary" id="comment-form">
                                        @include('starter-kit::component.err')
                                        <h5>
                                            ارسال دیدگاه
                                        </h5>
                                        <form class="xsumbmiter non-print" method="post" id="comment-form-body"
                                              action="no-action">
                                            <input type="hidden" id="smt"
                                                   value="{{route('n.comment.product',$pro->slug)}}">
                                            @csrf
                                            <input type="hidden" id="reply" name="parent" value="">
                                            <div class="row mb-3">
                                                <div class="col-md-12 mt-3">
                                                    <div class="form-group">
                                                        <label for="comment-message">
                                                        </label>

                                                        <textarea required="" minlength="10" id="comment-message"
                                                                  name="body" class="form-control " placeholder="پیام"
                                                                  rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <div class="form-group">

                                                        <input name="name" required="" minlength="2" type="text"
                                                               class="form-control " placeholder="نام" value=""
                                                               id="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <div class="form-group">

                                                        <input required="" name="email" id="email" type="email"
                                                               class="form-control " placeholder="ایمیل" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label> &nbsp;</label>
                                                    <input name="" type="submit" class="btn btn-primary mt-2"
                                                           value="ارسال دیدگاه">
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div id="tab-question">
                                <ul class="list-group container-sm mt-3">
                                    @foreach($pro->quesions_asnwered as $q)
                                        <li class="list-group-item">
                                            <span class="badge bg-secondary">
                                                پرسش
                                            </span>
                                            {{$q->body}}
                                            <hr>
                                            <span class="badge bg-info">
                                                پاسخ
                                            </span>
                                            <b>
                                                {{$q->answer}}
                                            </b>
                                        </li>
                                    @endforeach
                                </ul>
                                @if( !Auth::guard('customer')->check() )
                                    <h2 class="text-center p-4">
                                        شما برای ارسال سوال باید وارد حساب کاربری خود شوید
                                    </h2>
                                @else
                                    <div class="comment-containerx">
                                        <div class="meta">
                                            <img
                                                src="https://gravatar.com/avatar/{{md5(Auth::guard('customer')->user()->email)}}?s=80"
                                                class="avatar">
                                            <span class="name">نام کاربر</span>
                                        </div>
                                        <form id="question-form">
                                            <textarea class="form-control" dir="rtl" name="body"
                                                      placeholder="سوال شما..."></textarea>
                                            <input type="hidden" name="product_id" value="{{$pro->id}}">
                                        </form>
                                        <div class="btn btn-primary mt-3" id="question-send"
                                             data-url="{{route('question.send')}}">
                                            ارسال پرسش
                                        </div>
                                    </div>

                                @endif
                            </div>
                            <div id="tab-chart">
                                <!--                chart-->
                                <div>
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>

                                        </div>
                                    </div>
                                    {!! \App\Helpers\makeChart($pro) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wow fadeInRight">
                    <h4 class="mt-3">
                        محصولات مشابه
                    </h4>
                    <div class="owl-carousel owl-sq">
                        @foreach ($cat->products()->where('stock_quantity','>', 0)->limit(10)->get() as $p)
                            <div class="item ">
                                @include('website.component.product-box',['p' => $p])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </section>
        <input type="hidden" id="qn" value="">
        <input type="hidden" id="qnt" value='{!! $pro->quantities()->orderBy('price')->get();!!}'>
        <input type="hidden" id="colors" value='{!! json_encode( \App\Helpers\getColors()) !!}'>
@endsection

