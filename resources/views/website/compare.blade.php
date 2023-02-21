@extends('website.layout')
@section('title')
    {{__("Compare products")}} -
@endsection
@section('content')
    <div id="main-conetent">
        <section id="product" class="wow zoomInUp" data-wow-delay=".5">
            <div class="container">
               <div class="row">
                   @foreach ($pros as $pro)
                       <div class="col">
                           <h4>
                               {{$pro->name}}
                           </h4>
                           <a href="{{route('product',$pro->slug)}}">
                               <img src="{{$pro->thumbUrl()}}" class="img-fluid" alt="">
                           </a>
                           <ul class="product-info">
                               <li>
                                   <i class="fa fa-money-bill"></i>
                                   قیمت
                                   <b>
                                       <b class="price">
                                          {{$pro->getPrice()}}
                                       </b>
                                   </b>
                               </li>
                               <li>
                                   <i class="fa fa-weight"></i>
                                   وزن
                                   <b>
                                       <b>
                                           {{$pro->getMeta('weight')}}
                                           گرم
                                       </b>
                                   </b>
                               </li>
                               @foreach ($pro->category->props as $prop)
                                   <li>
                                       <i class="{{$prop->icon}}"></i>
                                       {{__($prop->label)}}
                                       <b>
                                           @if(\App\Helpers\isJson($pro->getMeta($prop->name)))
                                               @foreach(json_decode($pro->getMeta($prop->name)) as $x)
                                                   <span class="badge bg-primary">
                                                        {{$x->title}}
                                                   </span>
                                               @endforeach
                                           @elseif ($prop->name == 'color')
                                               <div style="width: 20px;height: 20px;background:{{$pro->getMeta($prop->name) }};"></div>
                                           @else
                                           {{$pro->getMeta($prop->name)}}
                                           @endif
                                       </b>
                                   </li>
                               @endforeach

                           </ul>
                           <a data-id="{{$pro->id}}" class="btn btn-warning btn-block mt-3 wow bounceInUp add-to-card" data-wow-delay="1s"
                              data-wow-duration="2s">
                               <i class="fa fa-shopping-cart"></i>
                               افزودن به سبد خرید
                           </a>
                           <a href="{{route('compare.rem',$pro->slug)}}" class="btn btn-danger btn-block mt-3">
                               <i class="fa fa-times"></i> &nbsp;
                               حذف از مقایسه
                           </a>
                       </div>

                   @endforeach
               </div>
            </div>
        </section>
    </div>
@endsection
