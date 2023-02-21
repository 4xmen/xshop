@extends('website.layout')
@section('content')
    <div id="main-conetent">
        <section id="product" class="wow zoomInUp" data-wow-delay=".5">
            <div class="container" style="min-height: 100vh">
                @include('starter-kit::component.err')
                @include('component.payment_result')

            </div>
        </section>
    </div>
@endsection
