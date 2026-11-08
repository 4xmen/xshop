<section class='SimplePost content live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="p-2">
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
                @if(config('app.xlang.active'))
                    <div class="col-md-1">
                        @foreach(\App\Models\XLang::all() as $lang)
                            @if($lang->tag != app()->getLocale() && ($page->getTranslation('body',$lang) != null && strlen($page->getTranslation('body',$lang)) > 10)  )
                                <a href="{{$page->webUrlLang($lang->tag)}}">
                                    {{$lang->emoji}}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <hr>
            <div class="post-content">
                    {!! fixShortCode($page->body) !!}
            </div>

        </div>
    </div>
</section>
