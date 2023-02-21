@extends('website.emptylayout')
@section('content')
    <div class="bg-dark">

        <video id="full-video" loop src="{{asset('video/under.mp4')}}" muted autoplay></video>
        <div class="container" id="under">
            <div>
                <h1>
                    {{config('app.name')}}
                </h1>
                <h2>
                    {{__("Under construction")}}
                </h2>
                <h3>
                    {{\App\Helpers\getSetting('tel')}}
                </h3>
                <div class="p4 text-center social">
                    @if(trim(\App\Helpers\getSetting('soc_in')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_in')}}">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_tg')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_tg')}}">
                            <i class="fab fa-telegram"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_wp')) != '')
                        <a target="_blank"
                           href="https://api.whatsapp.com/send/?phone={{urlencode(\App\Helpers\getSetting('soc_wp'))}}&text=%D8%A8%D8%A7%20%D8%B3%D9%84%D8%A7%D9%85%0A%D8%A7%D8%B2%20%D8%B3%D8%A7%DB%8C%D8%AA%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%B3%D9%81%D8%A7%D8%B1%D8%B4%20%D9%88%20%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C%20%D8%AA%D9%85%D8%A7%D8%B3%20%D9%85%DB%8C%DA%AF%DB%8C%D8%B1%D9%85&app_absent=0">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_tw')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_tw')}}">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_yt')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_yt')}}">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
