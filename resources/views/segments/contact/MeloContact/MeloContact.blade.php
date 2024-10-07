<section class='MeloContact'>
    <div class="{{gfx()['container']}}">

        <h1 class="text-center fw-light mb-3">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div class="row">
            <div class="col-md-5">
                <div class="pin-box p-3">
                    <i class="ri-mail-add-line icon"></i>
                    @if(getGroupBySetting($data->area_name.'_'.$data->part)?->posts()->where('status',1)->where('is_pinned',1)->count() == 0)
                        <h3 class="p-4 text-center">
                            {{__("You must add a pinned post to :GROUP",['GROUP' => getGroupBySetting($data->area_name.'_'.$data->part)?->name])}}
                        </h3>
                    @else
                        <h3>
                            {{getGroupBySetting($data->area_name.'_'.$data->part)?->posts()->where('status',1)->where('is_pinned',1)->first()->title}}
                        </h3>
                        {!! getGroupBySetting($data->area_name.'_'.$data->part)?->posts()->where('status',1)->where('is_pinned',1)->first()->body!!}

                        <ul class="social text-center">
                            @foreach(getSettingsGroup('social_')??[] as $k => $social)
                                <li class="d-inline-block mx-2">
                                    <a href="{{$social}}">
                                        <i class="ri-{{$k}}-line"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-7">

                @include('components.err')
                <form class="safe-form" method="post">
                    <input type="hidden" class="safe-url" data-url="{{route('client.send-contact')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name">
                                    {{__('Name and lastname')}}
                                </label>
                                <input name="full_name" type="text"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       placeholder="{{__('Name and lastname')}}"
                                       value="{{old('full_name',auth('customer')->user()->name??null)}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Phone">
                                    {{__('Phone')}}
                                </label>
                                <input name="phone" type="tel"
                                       class="form-control @error('Phone') is-invalid @enderror"
                                       placeholder="{{__('Phone')}}" value="{{old('Phone',auth('customer')->user()->mobile??null)}}"/>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="email">
                                    {{__('Email')}}
                                </label>
                                <input name="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="{{__('Email')}}" value="{{old('email',auth('customer')->user()->email??null)}}"/>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="subject">
                                    {{__('Subject')}}
                                </label>
                                <input name="subject" type="text"
                                       class="form-control @error('subject') is-invalid @enderror"
                                       placeholder="{{__('Subject')}}"
                                       value="{{old('subject')}}"/>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="body">
                                    {{__('Your message...')}}
                                </label>
                                <textarea name="bodya" style=" height: 150px;"
                                          class="form-control @error('bodya') is-invalid @enderror"
                                          placeholder="{{__('Question/Message')}}">{{old('body')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-112">
                            <label> &nbsp; </label>
                            <button class="btn btn-primary mt-2 w-100">
                                <i class="ri-send-plane-line"></i>
                                {{__('Send')}}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="py-5">

            @php($dir = langIsRTL(app()->getLocale() )?'rtl':'ltr' )

            @foreach( getGroupBySetting($data->area_name.'_'.$data->part)?->posts()->where('status',1)
            ->where('is_pinned',0)->orderByDesc('id')->get() as $i => $post)
                <div class="row mb-2" @if( ($i % 2) == 0) dir="rtl" @else dir="ltr" @endif>
                    <div class="col-md-2">
                        <img src="{{$post->imgUrl()}}" alt="{{$post->title}}" class="img-fluid" loading="lazy">
                    </div>
                    <div class="col-md" dir="{{$dir}}">
                        <h3>
                            <a href="{{$post->webUrl()}}">
                                {{$post->title}}
                            </a>
                        </h3>
                        <p>
                            {{$post->subtitle}}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
