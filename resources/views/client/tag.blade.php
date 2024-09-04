@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('content')
    @foreach(getParts('defaultHeader') as $part)
        @php($p = $part->getBladeWithData())
        @include($p['blade'],['data' => $p['data']])
    @endforeach
    <div class="{{gfx()['container']}} content tag-page">
        <div class="tab-control">
            <div class="row text-center">
                <a class="col-md py-2 active" href="#posts">
                    {{__("Posts")}} ({{count($posts)}})
                </a>
                <a class="col-md py-2" href="#products">
                    {{__("Products")}} ({{count($products)}})
                </a>
                <a class="col-md py-2" href="#clips">
                    {{__("Video clips")}} ({{count($clips)}})
                </a>
            </div>
        </div>
        <div>
            <div class="tab-content active px-0" id="posts">
                @if(count($posts) == 0)
                    <div class="alert alert-info">
                        {{__("There is nothing to show!")}}
                    </div>
                @else
                    <ul class="list-group">
                        @foreach($posts as $post)
                            <li class="list-group-item">
                                <img src="{{$post->imgUrl()}}" class="float-start x64-img me-2" alt="">
                                <h6>
                                    <a href="{{$post->webUrl()}}">
                                        {{$post->title}}
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    {{$post->subtitle}}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="tab-content px-0" id="products">
                @if(count($products) == 0)
                    <div class="alert alert-info">
                        {{__("There is nothing to show!")}}
                    </div>
                @else
                    <ul class="list-group">
                        @foreach($products as $product)
                            <li class="list-group-item">
                                <img src="{{$product->thumbUrl()}}" class="float-start x64-img me-2" alt="">
                                <h6>
                                    <a href="{{$product->webUrl()}}">
                                        {{$product->name}}
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    {{$product->excerpt}}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="tab-content px-0" id="clips">
                @if(count($clips) == 0)
                    <div class="alert alert-info">
                        {{__("There is nothing to show!")}}
                    </div>
                @else
                    <ul class="list-group">
                        @foreach($clips as $clip)
                            <li class="list-group-item">
                                <img src="{{$clip->imgUrl()}}" class="float-start x64-img me-2" alt="">
                                <h6>
                                    <a href="{{$clip->webUrl()}}">
                                        {{$clip->title}}
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    {{Str::limit(strip_tags($clip->body))}}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    @foreach(getParts('defaultFooter') as $part)
        @php($p = $part->getBladeWithData())
        @include($p['blade'],['data' => $p['data']])
    @endforeach
@endsection
