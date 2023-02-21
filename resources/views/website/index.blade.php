@extends('website.layout')
@section('body-class') pt-0 @endsection
@section('content')
    {{--    <section id="child">--}}
    {{--        <div id="particle"></div>--}}
    {{--        <div id="owl3" class="owl-carousel owl-theme">--}}
    {{--            @foreach($sliders as $x => $slider)--}}
    {{--                <div class="item @if(($x+1) % 2 == 0) owl-odd @endif">--}}
    {{--                    <div class="text">--}}
    {{--                        {!! $slider->body !!}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            @endforeach--}}

    {{--        </div>--}}
    {{--    </section>--}}
    <section id="index-top">
        <div class="container">
            <div class="grid">
                <div class="display-block position-relative">

                    <div id="owl2" class="owl-carousel owl-theme">
                        @foreach($sliders as $slider)
                            <div class="item">
                                        @if(\App\Helpers\findLink($slider->body) != null)
                                            <a href="{{\App\Helpers\findLink($slider->body)}}">
                                        @endif
                                        <img src="{{$slider->imgurl()}}" alt="">
                                        @if(\App\Helpers\findLink($slider->body) != null)
                                            </a>
                                        @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="position-relative xd">
                    <a href="{{\App\Helpers\getSetting('top2text')}}">
                        <img src="{{asset('images/mahi/sec1-1b.jpg')}}" alt="">
                    </a>
                </div>
                <div class="position-relative xd">
                    <a href="{{\App\Helpers\getSetting('top3text')}}">
                        <img src="{{asset('images/mahi/sec1-2b.jpg')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section id="new-products" class="mt-5">
        <div class="container pt-4 pb-4">
            <h1 class="mb-4">
                {{\App\Helpers\getSetting('sectext')}}
                <a href="{{route('products')}}" class="float-end btn btn-outline-primary">
                    همه محصولات
                </a>
            </h1>
            <div class="owl-carousel owl-theme owl1">
                @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('seccat'),'id','desc',10) as $p)
                    <div class="item">
                        @include('website.component.pro',['p' => $p])
                    </div>
                @endforeach

            </div>

        </div>
    </section>
    {{--    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="margin-top: -120px;margin-bottom: -100px;">--}}
    {{--        <path fill="#f442b3" fill-opacity="1"--}}
    {{--              d="M0,192L48,176C96,160,192,128,288,112C384,96,480,96,576,117.3C672,139,768,181,864,197.3C960,213,1056,203,1152,192C1248,181,1344,171,1392,165.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>--}}
    {{--    </svg>--}}
    <section style="">
        <div class="container">

            <div class="owl-carousel owl-theme" id="owlx1">
                @foreach( \App\Helpers\getMainCats(6) as $cat  )
                    <div class="item">
                        <a href="{{route('cat',$cat->slug)}}">
                            <img src="{{$cat->imgurl()}}" alt="{{$cat->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{--    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">--}}
    {{--        <path fill="#f442b3" fill-opacity="1"--}}
    {{--              d="M0,288L48,250.7C96,213,192,139,288,122.7C384,107,480,149,576,176C672,203,768,213,864,197.3C960,181,1056,139,1152,128C1248,117,1344,139,1392,149.3L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>--}}
    {{--    </svg>--}}

    <section id="boy">
        <div class="container">
            <hr>
            <h1>
                پسرانه
                <a href="{{route('cat',  \App\Helpers\getSettingCat('3cat')->slug )}}"
                   class="float-end btn btn-outline-primary">
                    مشاهده محصولات
                </a>
            </h1>
            <div class="owl-carousel owl-theme owl1">
                @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('seccat'),'id','desc',10) as $p)
                    <div class="item">
                        @include('website.component.pro',['p' => $p])
                    </div>
                @endforeach

            </div>
            <div class="row">
                @foreach(\App\Helpers\getSubCats(\App\Helpers\getSetting('4cat')) as $cat)
                    <div class="col">
                        <a href="{{route('cat',$cat->slug)}}">
                            <img src="{{$cat->thumbUrl()}}" class="img-fluid" title="{{$cat->name}}"
                                 alt="{{$cat->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="girl">
        <div class="container">
            <hr>
            <h1>
                دخترانه
                <a href="{{route('cat',  \App\Helpers\getSettingCat('seccat')->slug )}}"
                   class="float-end btn btn-outline-primary">
                    مشاهده محصولات
                </a>
            </h1>
            <div class="row">
                <div class="owl-carousel owl-theme owl1">
                    @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('4cat'),'id','desc',10) as $p)
                        <div class="item">
                            @include('website.component.pro',['p' => $p])
                        </div>
                    @endforeach

                </div>
                @foreach(\App\Helpers\getSubCats(\App\Helpers\getSetting('4cat')) as $cat)
                    <div class="col">
                        <a href="{{route('cat',$cat->slug)}}">
                            <img class="img-fluid" src="{{$cat->thumbUrl()}}" title="{{$cat->name}}"
                                 alt="{{$cat->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
