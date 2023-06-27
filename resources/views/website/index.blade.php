@extends('website.layout.layout')
@section('content')

    <!-- hero -->
    <header id="head-slider" class=" mt-3 container">
        <div class=" text-center  " id="header">
            <div class="row m-0">
                <div class="hero-carousel col-md-12 my-2 order-md-last order-first mt-3">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide container-sm"
                         data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                                    class="active"
                                    aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                                    aria-label="Slide 4"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"
                                    aria-label="Slide 5"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="3000">
                                <a href="{{\App\Helpers\getSetting('carousel-1-link')}}">
                                    <img src="{{asset('images/carousel/carousel-1.jpg')}}"
                                                            class="d-block w-100 "
                                                            alt="..."></a>
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <a href="{{\App\Helpers\getSetting('carousel-2-link')}}">
                                    <img src="{{asset('images/carousel/carousel-2.jpg')}}"
                                                            class="d-block w-100"
                                                            alt="..."></a>
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <a href="{{\App\Helpers\getSetting('carousel-3-link')}}">
                                    <img src="{{asset('images/carousel/carousel-3.jpg')}}"
                                                            class="d-block w-100"
                                                            alt="..."></a>
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <a href="{{\App\Helpers\getSetting('carousel-4-link')}}">
                                    <img src="{{asset('images/carousel/carousel-4.jpg')}}"
                                                            class="d-block w-100"
                                                            alt="..."></a>
                            </div>
                            <div class="carousel-item" data-bs-interval="3000">
                                <a href="{{\App\Helpers\getSetting('carousel-5-link')}}">
                                    <img src="{{asset('images/carousel/carousel-5.jpg')}}"
                                                            class="d-block w-100 "
                                                            alt="..."></a>
                            </div>
                        </div>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                                data-bs-slide="prev">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                                data-bs-slide="next">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-6">
                        <a href="{{\App\Helpers\getSetting('banner1-link')}}"><img src="{{asset('images/banner1.png')}}" alt=""></a>
                    </div>
                    <div class="col-6">
                        <a href="{{\App\Helpers\getSetting('banner2-link')}}"><img src="{{asset('images/banner2.png')}}" alt=""></a>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <!-- hero -->

    <!-- banners-->
    <section class="banners container mt-3">
        <div class="row m-0">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3 mt-sm-3 mt-md-0 ">
                <a href="{{\App\Helpers\getSetting('banner3-link')}}"><img src="{{asset('images/banner3.png')}}" alt=""></a>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-3 mt-sm-3 mt-md-0 ">
                <a href="{{\App\Helpers\getSetting('banner4-link')}}"><img src="{{asset('images/banner4.png')}}" alt=""></a>
            </div>
        </div>
    </section>
    <!-- banners-->

    <!-- services-->
    <div class="head-services container mt-3">
        <div class="row m-0">
            @if(\App\Helpers\getSettingCategory('supports') != null)
                @foreach(\App\Helpers\getSettingCategory('supports')->posts as $p)
                    <div class="serv-box col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                        <a href="{{route('n.show',$p->slug)}}">
                            <div class="row m-0">
                                <div class="col-4">
                                    <img src="{{$p->imgUrl()}}" style="max-height: 58px;" alt="">
                                </div>
                                <div class="col-8">
                                    <h4>
                                        {{$p->title}}
                                    </h4>
                                    <span>
                                {{$p->subtitle}}
                            </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- services-->

    <!-- slider 1-->
    <div class="slider-title container mt-4">
        <h5>
            محصولات آرایشی
        </h5>
    </div>
    <section class="slider container ">
        <div class="main-content">
            <div class="owl-carousel owl-theme">
                @foreach($disPros as $pro)
                <div class="item">
                    <a href="{{route('product',$pro->slug)}}">
                        <div class="slider-box">
                            <img src="{{$pro->thumburl()}}" alt="Picture 1">
                            <h5>
                                {{$pro->name}}
                            </h5>
                            <del>
                                {{$pro->getOldPrice()}}
                            </del>
                            <h6>
                                {{$pro->getPurePrice()}}
                            </h6>
                            <img src="{{asset('images/sale.svg')}}" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="owl-theme">
                <div class="owl-controls">
                    <div class="custom-nav owl-nav"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider 1-->

    <!-- offer banners mid-->
    <div class="offer-mid-banner mt-3 container">
        <div class="row m-0">
            <div class="col-6">
                <a href="{{\App\Helpers\getSetting('offer1-link')}}"><img src="{{asset('images/offer1.png')}}" alt=""></a>
            </div>
            <div class="col-6">
                <a href="{{\App\Helpers\getSetting('offer2-link')}}"><img src="{{asset('images/offer2.png')}}" alt=""></a>
            </div>
        </div>
    </div>
    <!-- offer banners mid-->

    <!-- slider 2-->
    <div class="slider-title container mt-4">
        <h5>
            محصولات بهداشتی
        </h5>
    </div>
    <section class="slider container ">
        <div class="main-content">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-2.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-1.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-3.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-4.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="owl-theme">
                <div class="owl-controls">
                    <div class="custom-nav owl-nav"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider 2-->

    <!-- slider 3-->
    <div class="slider-title container mt-4">
        <h5>
            محصولات بهداشت بدن
        </h5>
    </div>
    <section class="slider container ">
        <div class="main-content">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-2.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-1.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-3.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
                <div class="item">
                    <a href="product.html">
                        <div class="slider-box">
                            <img src="assets/img/index/products/p-4.jpeg" alt="Picture 1">
                            <h5>
                                نام محصول
                            </h5>
                            <del>185.000</del>
                            <h6>165.200</h6>
                            <img src="assets/img/sale.svg" class="sale-off" alt="">
                        </div>
                    </a>
                </div>
            </div>
            <div class="owl-theme">
                <div class="owl-controls">
                    <div class="custom-nav owl-nav"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider 3-->

@endsection
