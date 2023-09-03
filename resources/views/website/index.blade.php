@extends('website.layout.layout')
@section('content')
    <section>
        <div class="owl-carousel owl-theme owl-single-item">
            @foreach(\Xmen\StarterKit\Models\Slider::where('active',1)->limit(5)->get() as $sld)
                <a class="item img-vh100-full-width" href="{{strip_tags($sld->body)}}">
                    <img src="{{$sld->imgUrl()}}" alt="">
                </a>
            @endforeach
        </div>
    </section>
    <section id="index-top">
        <div class="container">
            <div class="grid">
                <div class="display-block position-relative">
                    <div class="fa fa-mobile-alt fa-bg"></div>
                    <h2 class="mt-5 ms-3">
                        {{\App\Helpers\getSetting('top1text')}}
                    </h2>
                    <div class="clearfix mt-5 mb-5"></div>
                    <div id="owl2" class="owl-carousel owl-theme">
                        @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('top1cat'),'id','desc',10) as $p)
                            <div class="item">
                                <div class="box">
                                    <a href="{{route('product',$p->slug)}}">
                                        <img src="{{$p->thumbUrl()}}" class="img-fluid" alt="{{$p->name}}"
                                             title="{{$p->name}}">
                                        <h4>
                                            {{$p->name}}
                                        </h4>
                                    </a>
                                    <span>
                            {{$p->getPrice()}}
                        </span>
                                    <a href="{{route('card.add',$p->slug)}}"
                                       class="add-to-card btn btn-primary btn-block mt-2 mb-2">
                                        <img src="{{asset('images/basket.svg')}}" class="basket-icon" alt=""> &nbsp;
                                        افزودن به سبد خرید
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="position-relative">
                    @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('top2cat'),'id','desc',2) as $p)
                        <article>
                            <a href="{{route('product',$p->slug)}}">

                                <img src="{{$p->thumbUrl()}}" alt="{{$p->name}}" title="{{$p->name}}">
                                <div>
                                    <div class="text-light">
                                        {{$p->getPrice()}}
                                    </div>
                                </div>
                            </a>
                            <span class="badge bg-secondary discount">
                                {{\App\Helpers\getSetting('top2text')}}
                    </span>
                        </article>
                    @endforeach

                </div>
                <div class="position-relative">
                    @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('top3cat'),'id','desc',2) as $p)
                        <article>
                            <a href="{{route('product',$p->slug)}}">

                                <img src="{{$p->thumbUrl()}}" alt="{{$p->name}}" title="{{$p->name}}">
                                <div>
                                    <div class="text-light">
                                        {{$p->getPrice()}}
                                    </div>
                                </div>
                            </a>
                            <span class="badge bg-secondary discount">
                                {{\App\Helpers\getSetting('top3text')}}
                    </span>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section id="new-products" class="mt-5 long-box">
        <div class="container pt-4 pb-4">
            <h1 class="mb-4">
                {{\App\Helpers\getSetting('sectext')}}
            </h1>
            <div id="owl1" class="owl-carousel owl-theme owl1">
                @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('seccat'),'id','desc',10) as $p)
                    <div class="item ">
                        <div class="box">
                            <a href="{{route('product',$p->slug)}}">
                                <img src="{{$p->thumbUrl()}}" class="img-fluid" alt="{{$p->name}}" title="{{$p->name}}">
                            </a>
                            <a href="{{route('product',$p->slug)}}">
                                <h4>
                                    {{$p->name}}
                                </h4>
                                <span>
                                  {{$p->getPrice()}}
                        </span>
                            </a>
                            <div>
                                <a href="{{route('card.add',$p->slug)}}"
                                   class="add-to-card btn btn-primary btn-block mt-2 mb-2 corner">
                                    <img src="{{asset('images/basket.svg')}}" class="basket-icon" alt=""> &nbsp;
                                    افزودن به سبد خرید
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <a href="{{route('products')}}" class="float-end btn btn-outline-primary">
                همه محصولات
            </a>
            <br>
            <br>
        </div>
    </section>
    <section id="filtering" class="pb-4 pt-4 bg long-box">
        <div class="container">
            <h1>
                {{\App\Helpers\getSetting('3text')}}
            </h1>
            <div class="btn-group mt-3" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary active" data-cat="all">همه</button>
                @foreach(\App\Helpers\getSubCats(\App\Helpers\getSetting('3cat')) as $cat)
                    <button type="button" class="btn btn-primary" data-cat="cat{{$cat->id}}">
                        {{$cat->name}}
                    </button>
                @endforeach
            </div>
            <div id="da-thumbs" class="da-thumbs">
                @foreach(\App\Helpers\getProductByCat(\App\Helpers\getSetting('3cat'),'stock_quantity','desc',12) as $p)
                    <div
                        class="item custom @foreach($p->categories()->pluck('id')->toArray() as $c) cat{{$c}} @endforeach shad pad">
                        <div class="box">
                            <a href="{{route('product',$p->slug)}}">
                                <img src="{{$p->thumbUrl()}}" class="img-fluid" alt="{{$p->name}}" title="{{$p->name}}">
                                <h4>
                                    {{$p->name}}
                                </h4>
                            </a>
                            <span>

                          {{$p->getPrice()}}
                        </span>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section id="blog">
        <div class="container">
            <h1>
                واپسین مطالب
            </h1>
            <hr>
            <div class="row">
                @foreach(\Xmen\StarterKit\Models\Post::where('status',1)->limit(4)->get() as $p)
                    <div class="col-md-3">
                        <a href="{{route('n.show',$p->slug)}}" class="text-dark text-decoration-none">
                            <div class="mb-4 card post-card">
                                <img src="{{$p->imgurl()}}" class="img-fluid" alt="{{$p->title}}" title="{{$p->title}}">
                                <div class="card-body">
                                    <h3 class="textt">{{$p->title}}</h3>
                                    <div class="mb-2">
                                        @foreach($p->tags as $tag)
                                            <a class="post-tag ms-2" href="{{route('n.tag',$tag->slug)}}">
                                                {{$tag->name}}
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="mb-1 text-muted">
                                        {{$p->created_at->jdate('Y/m/d')}}
                                    </div>
                                    <p>
                                        {{$p->subtitle}}
                                    </p>
                                    <div class="text-muted text-end text-xsmall">
                                        <i class="fa fa-comments"></i>
                                        دیدگاه‌:
                                        {{$p->comments()->count()}}
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>
            <a href="{{route('posts')}}" class="btn btn-outline-light float-end">
                همه مطالب
            </a>
            <br>
        </div>
    </section>
    <section id="brand" class="pt-4 pb-4">
        <div class="container">
            <h1>
                برندها
            </h1>
            <div class="row">
                @foreach(\App\Helpers\getSubCats(\App\Helpers\getSetting('4cat')) as $cat)
                    <div class="col-md-2 col-sm-3 col-4">
                        <a href="{{route('cat',$cat->slug)}}">
                            <img src="{{$cat->thumbUrl()}}" title="{{$cat->name}}" alt="{{$cat->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
