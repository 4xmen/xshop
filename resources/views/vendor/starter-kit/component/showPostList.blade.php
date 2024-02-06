@foreach($posts as $n)
    <article class="mb-3">
        <div class="row">
            <div class="col-md-3">
                {{--                {{$n->getMedia()->first()->getUrl('news-image')}}--}}
                <img src="{{$n->imgurl()}}"  class="img-fluid" alt="{{$n->title}}" title="{{$n->title}}">
            </div>
            <div class="col-md-9">
                <h3>
                    <a href="{{route('post.show',$n->slug)}}">
                        {{$n->title}}
                    </a>
                </h3>
                {{mb_substr($n->subtitle,0,300)}}...
            </div>
        </div>
    </article>
@endforeach
<div class="text-center">
    {{$posts->links()}}
</div>
