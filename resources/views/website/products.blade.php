@extends('website.layout')
@section('title')
    {{__("Products")}} -
@endsection
@section('content')

    <section id="list" >
        <h1 style="display: none">
            {{$title??'محصولات'}}
        </h1>
        <div class="container pt-5">
            <div class="row">
                @if ( isset($products) && $products != null & count($products) > 0)
                    <div class="col-12">
                        <div>
{{--                            <img class=" mt-1 me-3 float-start icon-size" style="position: relative;top: -25px"--}}
{{--                                 src="{{asset('images/track.svg')}}" alt="ارسال آنی">--}}
{{--                            <h6 class="mt-1 text-muted">--}}
{{--                                ارسال آنی در تهران--}}
{{--                            </h6>--}}
                            <hr>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4">
                        @include('website.sidebar')
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="list-grid">
                            @foreach($products as $pro)
                                <div class="item">
                                    @include('website.component.pro',['p' => $pro])
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
                    <h1>
                        404
                    </h1>
                    <h2 class="col-md-12 text-center align-items-center justify-content-center d-flex" style="min-height: 75vh">
                        <img src="{{asset('images/404.png')}}" class="404" alt="404" style="width: 250px">
                        <br>
                        محصولی مطابق با درخواست شما پیدا نشد
                    </h2>
                @endif
            </div>
        </div>
    </section>
@endsection
