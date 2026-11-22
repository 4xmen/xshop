<section class="ShahedPosts live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >

    <div class="blog py-5">
        <div class="{{gfx()['container']}} px-4 px-xxl-5">

            <header class="d-flex flex-wrap align-items-end justify-content-between mb-4">
                <div>
                    <h1>{{getSetting($data->area_name.'_'.$data->part.'_title')}}</h1>
                </div>

                <a href="{{route('client.posts')}}" class="d-inline-flex align-items-center gap-2 mb-2">
                    {{__("Read the Blog")}}
                    <i class="ri-arrow-right-line"></i>
                </a>
            </header>

            <div class="row g-4">

                @foreach(\App\Models\Post::with('mainGroup')->where('status',1)->orderByDesc('updated_at')->limit(3)->get() as $post)

                <div class="col-12 col-md-6 col-lg-4">
                    <article>
                        <a href="{{$post->webUrl()}}">
                            <img src="{{$post->imgUrl()}}" alt="Skincare products on a table">
                        </a>

                        <p class="meta"><a href="{{$post->mainGroup->webUrl()}}">{{$post->mainGroup->name}}</a> · {{__("Time spend")}}: {{$post->spendTime()}}</p>
                        <h2>
                            <a href="#">{{$post->title}}</a>
                        </h2>
                    </article>
                </div>
                @endforeach


            </div>
        </div>
    </div>

</section>
