@extends('website.layout')
@section('title')
    {{$post->title}} -
@endsection
@section('content')


    <section id="single">
        <div class="container">
            <div aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('welcome')}}">
                            {{config('app.name')}}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('n.mag')}}">
                            {{__("Magazine")}}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('n.category',$post->categories()->first()->slug)}}">
                            {{$post->categories()->first()->name}}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{$post->title}}
                    </li>
                </ol>
            </div>
            <h1>
                {{$post->title}}
            </h1>
            @if($post->subtitle != null)
                <div class="alert alert-info" style="text-align: center">
                    {{$post->subtitle}}
                </div>
            @endif
            <img src="{{$post->imgUrl()}}" class="img-fluid" alt="{{$post->title}}" title="{{$post->title}}">
            <div class="content">
                {!!$post->body!!}
            </div>
            <hr>
            <div class="alert " id="comment-form">


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
                        <form class="xsumbmiter non-print" method="post" id="comment-form-body" action="no-action">
                            <input type="hidden" id="smt"  value="{{route('n.comment.post',$post->slug)}}">
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
        </div>
    </section>


@endsection
