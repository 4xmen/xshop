<section class="UnrealFooter live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >

    <footer class="site-footer" dir="rtl">
        <div class="container">

            <!-- Main Footer -->
            <div class="footer-main">

                <div class="row g-4 align-items-stretch">

                    <!-- About Section -->
                    <div class="col-lg-4 col-md-12">
                        <div class="footer-about">
                            <div class="footer-about-content">
                                <div class="footer-logo">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>
                                        {{config('app.name')}}
                                    </span>
                                </div>

                                <h4>
                                    {{getSetting('subtitle')}}
                                </h4>

                                    {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
                            </div>
                        </div>
                    </div>

                    <!-- Footer Links -->
                    <div class="col-lg-8 col-md-12">
                        <div class="footer-information">

                            <!-- Social Links -->
                            <div class="footer-top">
                                <div class="footer-social">
                                    <a href="tel:{{getSetting('tel')}}" class="social-item phone">
                                        <i class="ri-phone-line"></i>
                                    </a>
                                    <a href="mailto:{{getSetting('email')}}" class="social-item email">
                                        <i class="ri-mail-open-line"></i>
                                    </a>
                                    @foreach(getSettingsGroup('social_')??[] as $k => $social)
                                    <a href="{{$social}}" class="social-item {{$k}}">
                                        <i class="ri-{{$k}}-line"></i>
                                    </a>
                                    @endforeach



                                </div>

                                <a href="{{getSetting($data->area_name.'_'.$data->part.'_main_link')}}" class="footer-main-title">
                                    {{getSetting($data->area_name.'_'.$data->part.'_main_title')}}
                                </a>
                            </div>

                            <div class="footer-divider"></div>

                            <!-- Footer Columns -->
                            <div class="row g-4 footer-links">

                                <!-- Popular Links -->
                                <div class="col-md-4 col-sm-6">
                                    <h6>
                                        {{__("Most visits")}}
                                    </h6>

                                    <ul>
                                        @foreach(\App\Models\Post::where('status',1)->orderByDesc('view')->limit(5)->get() as $post)
                                        <li><a href="{{$post->webUrl()}}">{{$post->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Useful Links -->
                                <div class="col-md-4 col-sm-6">
                                    <h6>
                                        {{getSetting($data->area_name.'_'.$data->part.'_sub_title')}}
                                    </h6>

                                    <ul>
                                        @foreach(getPagesSet($data->area_name.'_'.$data->part.'_pages') as $page)
                                        <li>
                                            <a href="{{$page->webUrl()}}">
                                                {{$page->title}}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Contact -->
                                <div class="col-md-4 col-sm-12">
                                    <h6>{{__("Contact us")}}</h6>

                                    <ul class="footer-contact">
                                        <li>
                                            <i class="ri-phone-line"></i>
                                            <a href="tel:{{getSetting('tel')}}">{{getSetting('tel')}}</a>
                                        </li>

                                        <li>
                                            <i class="ri-mail-open-line"></i>
                                            <a href="mailto:{{getSetting('email')}}">
                                                {{getSetting('email')}}
                                            </a>
                                        </li>

                                        <li>
                                            {!! getSetting($data->area_name.'_'.$data->part.'_contact') !!}
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright">
                <div class="row align-items-center gy-3">

                    <div class="col-md-6 text-center text-md-start">
                        <p>
                           {{getSetting('copyright')}}
                        </p>
                    </div>

                    <div class="col-md-6 text-center text-md-end">
                        <span>
                            {{__("Powered by:")}}
                        </span>
                        <a href="#">{{__("xShop")}}</a>
                    </div>

                </div>
            </div>

        </div>
    </footer>

</section>
