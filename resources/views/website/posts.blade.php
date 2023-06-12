@extends('website.layout.layout')
@section('title')
    {{$title}} -
@endsection
@section('content')
    <section style="background: #efefef;">
        <div class="container pt-5">
            <h1 id="font">
                {{$title}}
            </h1>
            <br>
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @foreach($posts as $p)
                            <div class="col-md-4">
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
                                                {{\App\Helpers\time2persian($p->created_at)}}
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
                </div>
                <div class="col-md-3">
                    <div class="card card-post">
                        <h5 class="card-header text-center">
                            واپسین مطالب
                        </h5>
                        <ul class="list-group">
                            @foreach(\Xmen\StarterKit\Models\Post::latest()->limit(10)->get() as $post)
                                <li class="list-group-item">
                                    <a href="">
                                        {{$post->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card card-post mt-4">
                        <h5 class="card-header text-center">
                            پر بازدید ترین مطالب
                        </h5>
                        <ul class="list-group">
                            @foreach(\Xmen\StarterKit\Models\Post::inRandomOrder()->limit(10)->get() as $post)
                                <li class="list-group-item">
                                    <a href="" class="row">
                                        <div class="col-4">
                                            <img src="{{$post->imgurl()}}" class="img-fluid" alt="{{$post->title}}">
                                        </div>
                                        <div class="col-8">
                                        {{$post->title}}
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center">
                {{$posts->links()}}
            </div>
        </div>
    </section>
@endsection
