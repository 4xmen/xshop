<section class='OtherFooter mt-5 live-setting' data-live="{{$data->area_name.'_'.$data->part}}">


    <footer id="footer" class="footer-1">
        <div id="mapcContainer" @if(getSetting($data->area_name.'_'.$data->part.'_dark')) class="dark-mode" @endif>

        </div>
        @php($mapData = explode(',',getSetting($data->area_name.'_'.$data->part.'_loc')))
        <input type="hidden" id="mapclat" value="{{$mapData[0]}}">
        <input type="hidden" id="mapclng" value="{{$mapData[1]}}">
        <input type="hidden" id="mapczoom" value="{{$mapData[2]}}">
        <div class="main-footer widgets-dark typo-light">
            <div class="container-fluid">
                <div class="d-flex flex-md-row flex-column justify-content-between">
                    <div class="address mt-3">
                        <div class="address-box">
                            <img src="{{asset('upload/images/logo.png')}}" class="footer-logo float-start m-4" alt="">
                            <p>
                                {!! getSetting($data->area_name.'_'.$data->part.'_first') !!}
                            </p>
                        </div>
                    </div>
                    <div class="form" data-bs-theme="light">
                        <form class="safe-form" method="post">
                            <input type="hidden" class="safe-url" data-url="{{route('client.send-contact')}}">
                            @csrf
                            <h4 class="text-center  text-dark">
                                {{__("Contact us")}}
                            </h4>
                            <div class="form-group">
                                <label for="name">
                                    {{__("Name")}}
                                </label>
                                <input type="text" id="name" name="" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    {{__("Mobile")}}
                                </label>
                                <input type="text" id="phone" name="" value="" class="form-control">
                            </div>
                            <input type="hidden" name="subject" value="{{__("Fast contact form")}}">
                            <div class="form-group">
                                <label for="email">
                                    {{__("Email")}}
                                </label>
                                <input type="email" id="email" name="email" value=""
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="content">
                                    {{__("Your message...")}}
                                </label>
                                <textarea name="content" class="form-control"  id="content" rows="4" placeholder=""> </textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <button class="btn btn-dark border-0 submit-btn" >
                                    <i class="ri-send-plane-line"></i>
                                    {{__("Send")}}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="address mt-3" >
                        <div class="address-box second">
                            <h4>
                                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                            </h4>
                            <p>

                            {!! getSetting($data->area_name.'_'.$data->part.'_last')!!}
                            </p>
                            <div class="icons">
                                <ul class="social text-center">
                                    @foreach(getSettingsGroup('social_')??[] as $k => $social)
                                        <li class="d-inline-block mx-2">
                                            <a href="{{$social}}">
                                                <i class="ri-{{$k}}-line"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="probootstrap-copyright">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center footer-copyright2">
                                    <p class="pt-3">
                                        {{getSetting('copyright')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</section>
