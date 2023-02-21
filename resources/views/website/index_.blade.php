@extends('website.layout')
@section('content')
<div id="main-conetent">
    <section>
        <div class="container overflow-hidden wow bounceInUp" data-wow-delay="1s"
             data-wow-duration="2s" >
            <div class="owl-single owl-carousel">
                @foreach( $sliders as $sld )
                    <div class="item">
                        <img src="{{$sld->imgUrl()}}" alt="{{strip_tags($sld->body)}}">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <br>
    <section>
        <div class="container">
            <div class="row wow bounceInRight" data-wow-delay="1.2s"
                 data-wow-duration="2s">
                <div class="col-md-6 mb-3">
                    <img src="{{asset('images/left.jpg')}}" alt="">
                </div>
                <div class="col-md-6 mb-3">
                    <img src="{{asset('images/right.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="index-list">

                <div class="row">
                    @foreach($cats as $cat)
                    <div class="col-md-4 wow fadeIn" data-wow-delay="1.1s">
                        <a href="{{route('cat',$cat->slug)}}" class="index-list-item" style="background-image: url('{{$cat->thumbUrl()}}')">
                            <div>
                                {{$cat->name}}
                                <br>
                                <div class="btn btn-sm btn-gold">
                                    مشاهده
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if ($vid != null)

    <section id="parallax" style="background-image:url('{{asset('client/img/para.jpg')}}')">
        <div class="container text-center">
            <h2>
                {{$vid->name}}
            </h2>
            <video src="{{$vid->fileUrl()}}" poster="{{$vid->coverUrl()}}" controls style="width: 100%"></video>
        </div>
    </section>
    @endif
@endsection
