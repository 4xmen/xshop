@extends('website.layout.layout')
@section('title')
    {{$cat->name}} -
@endsection
@section('content')

{{--    <div class="parallax" style="background-image: url('{{$cat->backUrl()}}')">--}}

{{--    </div>--}}
    <section id="list" >
        <h1 style="display: none">
            {{$title??'محصولات'}}
        </h1>
        <div class="container pt-5">
            <div class="row">
                @if (count($products) > 0)
                    <div class="col-12">
                        <div>
                            <img class=" mt-1 me-3 float-start icon-size" style="position: relative;top: -25px"
                                 src="{{asset('images/track.svg')}}" alt="ارسال آنی">
                            <h6 class="mt-1 text-muted">
                                ارسال آنی در تهران
                            </h6>
                            <hr>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4">
                        <aside class="mb-5">
                            <input type="hidden" id="catId" value="{{$cat->id}}" data-url="{{route('props.list',$cat->id)}}">

                            <meta-search id="jdata" ref="metaEl" cls="side-box"
                                         :searchable="true" :defz="def" :jdata='jdata'
                                         @if($cat->products()->min('price') != null)
                                         :minm="{{$cat->products()->min('price')}}"
                                         @else
                                         :minm="0"
                                         @endif
                                         @if($cat->products()->max('price') != null)
                                         :maxm="{{$cat->products()->max('price')}}"
                                         @else
                                         :maxm="1000000000"
                                @endif

                            >
                        @include('website.layout.sidebar')
                        </meta-search>
                        </aside>
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="list-grid">
                            @foreach($products as $pro)
                                <div class="item">
                                    @include('website.component.product-box',['p' => $pro])
                                </div>
                            @endforeach
                        </div>
                        <div class="pt-4 text-center">
                            <div aria-label="..." class="display-block m-auto">
                                {{$products->withQueryString()->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <h1 class="col-md-12">
                        محصولی مطابق با درخواست شما پیدا نشد
                    </h1>
                @endif
            </div>
        </div>
    </section>
@endsection
