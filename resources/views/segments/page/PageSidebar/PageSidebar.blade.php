<section class='PostSidebar content live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <dov class="row">
            @if(!getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-0">
                    @include('segments.post.PostSidebar.inc.sidebar')
                </div>
            @endif
            <div class="col-lg-9 p-0">
                <div class="py-2 px-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{homeUrl()}}">
                                    {{config('app.name')}}
                                </a>
                            </li>
                            @if($page->parent_id != null)
                                <li class="breadcrumb-item">
                                    <a href="{{$page->parent->webUrl()}}">
                                        {{$page->parent->title}}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$page->title}}
                            </li>
                        </ol>
                    </nav>
                    <img src="{{$page->orgUrl()}}" alt="{{$page->title}}" class="img-fluid" loading="lazy">
                    <p class="text-muted my-3">
                        {{$page->subtitle}}
                    </p>
                    <div class="row text-center">
                        <div class="col-md">
                            <i class="ri-calendar-line"></i>
                            {{$page->created_at->ldate('Y/m/d H:i')}}
                        </div>
                        <div class="col-md">
                            <i class="ri-eye-line"></i>
                            {{number_format($page->view)}}
                        </div>
                        <div class="col-md">
                            <a href="#share-modal" class="share-btn">
                                <i class="ri-share-line"></i>
                            </a>
                        </div>

                    </div>
                    <hr>
                    <div class="post-content">


                            {!! fixShortCode($page->body) !!}
                    </div>

                </div>

            </div>
            @if(getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-0">
                    @include('segments.post.PostSidebar.inc.sidebar')
                </div>
            @endif
        </dov>
    </div>
</section>
