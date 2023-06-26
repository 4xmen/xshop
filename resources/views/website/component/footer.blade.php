<!-- back to top -->
<div class="back-top-btn col-12 container mt-4">
    <button class="mb-4 backtop-btn" id="myBtn" title="بازگشت به بالا">
        <div>
            <span>
                <p class="mt-3">بازگشت به بالا</p>
            </span>
        </div>
        <div>
            <span>
                <p class="d-block m-auto">
                    <i class="fa fa-arrow-up"></i>
                </p>
            </span>
        </div>
    </button>
</div>
<!-- back to top -->

<!-- top footer description -->
<div class="top-footer ">
    <hr class="container">
    <div class="top-footer-title container">
        <h4>
            فروشگاه اینترنتی فرداد، خرید لوازم آرایشی و بهداشتی، همراه زیبایی شما
        </h4>
        <p>
            فروشگاه اینترنتی فرداد، مجموعه ی کاملی از بهترین برندهای لوازم آرایشی و بهداشتی در سراسر جهان را فراهم
            آورده تا نیاز یکایک شما را برای خرید اینترنتی لوازم آرایشی و بهداشتی برآورده نماید. این مجموعه، شامل انواع
            لوازم آرایشی برای آرایش صورت، چشم، ابرو، لب، بدن، ناخن و به طور کل مجموعه ای مجهز از ابزارهای آرایشی است. جز
            آن لیستی کامل از ملزومات در زمینه مراقبت از پوست، محصولات مو و همینطور اکسسوری و زیورآلات می شود. شما می
            تواند خریدهای خود در زمینه آرایشی-بهداشتی را با مناسب ترین قیمت و همینطور با استفاده از آفرهای ویژه از جمله
            بخش جذاب آفروز در فرداد انجام دهید.
        </p>
        <h4>
            برترین فروشگاه اینترنتی لوازم آرایشی و بهداشتی سال ۹۷ ایران
        </h4>
        <p>
            فروشگاه اینترنتی فرداد، با بیش از ربع قرن تجربه در حوزه لوازم آرایشی و بهداشتی، موفق به کسب تندیس «برترین
            فروشگاه اینترنتی لوازم آرایشی» با رای مردمی و نظر داوران از جشنواره وب موبایل ایران در سال ۹۷ شد. این امر با
            پایبندی بر سه اصل مهم: تضمین اصل بودن کالا (با تأییدیه وزارت بهداشت)، ۷ روز ضمانت بازگشت کالا و مشاوره تخصصی
            تحقق یافت. همینطور توانستیم در همایش صنایع سلامت محور در دی ماه ۱۴۰۰ به عنوان برند نمونه در حفظ سلامت
            مشتریان، مفتخر به دریافت تندیس بلورین شویم.
        </p>
        <p>
            فروشگاه اینترنتی فرداد، جهت رفاه و جلب رضایت مشتریان خود، روش های پرداخت متنوع را پیاده سازی کرده است تا
            خرید لوازم آرایشی و بهداشتی را در هر زمان و مکانی میسر سازد. از دیگر ویژگی های فروشگاه اینترنتی فرداد، می
            توان به تحویل کالا به صورت رایگان (برای خرید بالای ۲۵۰ هزار تومان) و تحویل ۲۴ ساعته در تهران اشاره نمود.
        </p>
        <p>
            ما در فروشگاه اینترنتی فرداد، برای شما انواع برندهای معتبر داخلی و خارجی از جمله اوریفلیم، ایزادورا،
            لورال، اسنس، بورژوا، مارال و ... را موجود نموده ایم و شما می توانید محصولات این برندها را بصورت اصل و
            اورجینال در سایت تهیه نمایید. این بین برخی از محصولات در فروشگاه ما مورد توجه بیشتری از سوی شما قرار گرفته
            اند؛ از آن جمله می توان به کرم پودر لورال و انواع شامپو بدون سولفات اشاره کرد.
        </p>
        <h4>
            مشاوره تخصصی آرایشی برای شما
        </h4>
        <p>
            فروشگاه اینترنتی فرداد برای پاسخ به سوالات و مشکلات زیبایی شما عزیزان، بستر شبکه اجتماعی (اینستاگرام و
            توییتر) و مجله اینترنتی فرداد را فراهم آورده، تا بتوانید نیازها و مشکلات آرایشی خود را رفع نمایید و با
            بهترین برندهای لوازم آرایشی و بهداشتی آشنا شوید. همچنین شما می توانید برای رفع مشکلات آرایشی خود با تیم
            پشتیبانی فرداد تماس بگیرید و سوالات خود را از این تیم بپرسید. همینطور در مجله اینترنتی فرداد می توانید
            به صورت رایگان از مقالات تخصصی و آموزشی در حوزه آرایش، زیبایی و سلامت بهره ببرید.
        </p>
    </div>
    <hr class="container">
    <!-- footer -->
    <footer class="footer mt-0">
        <div class="main-footer container">
            <div class="row m-0">
                <div
                    class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 text-center text-sm-center text-md-start text-lg-start">
                    <h6>
                        {{\App\Helpers\getSettingCategory('footer1')->name}}
                    </h6>
                    <ul class="footer-links">
                        @foreach(\App\Helpers\getSettingCategory('footer1')->posts as $p)
                            <li>
                                <a href="{{route('n.show',$p->slug)}}">
                                    {{$p->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div
                    class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4 text-center text-sm-center text-md-start text-lg-start">
                    <h6>
                        {{\App\Helpers\getSettingCategory('footer2')->name}}
                    </h6>
                    <ul class="footer-links">
                        @foreach(\App\Helpers\getSettingCategory('footer2')->posts as $p)
                            <li>
                                <a href="{{route('n.show',$p->slug)}}">
                                    {{$p->title}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-mail col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    <p>برای اطلاع از آخرین تخفیف‌ها و جدیدترین کالا‌ها در خبرنامه ثبت‌نام کنید.</p>
                    <div class="container-inp">
                        <input type="email" required name="mail" class="input" placeholder="ایمیل خود را وارد کنید">
                        <button class="search__btn" name="mail">
                            <i class="fa-solid fa-envelope"></i>
                        </button>
                    </div>
                    <a href="{{url('/')}}">
                        <img src="{{asset('images/logo.png')}}" class="d-block m-auto mt-4 " width="70" height="70"
                             alt="">
                    </a>
                </div>
            </div>
            <div class="validity row m-0">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                    <div class="row m-0">
                        <div class="col-6">
                            {!! \App\Helpers\getSetting('footer3') !!}
                        </div>
                        <div class="col-6">
                            {!! \App\Helpers\getSetting('footer4') !!}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                    <p class="footer-para">
                        افراد گروه سوم از اهمیت به پایان رساندن آگاه هستند. آنها با تفکر منطقی، طرحی روشن ارائه می‌کنند.
                        آنها نه تنها برای پایان دادن به پروژه‌ی خود در آینده برنامه ریزی می‌کنند، بلکه به تمام نتایج
                        آینده برنامه ریزی می‌کنندآینده برنامه ریزی می‌کنندآینده برنامه ریزی می‌کنندآیندهآینده برنامه
                        ریزی می‌کنندآیندهریزی می‌کنندآیندمی‌کنندآینده برنامه ریزی بلکه به تمام نتایج و
                        عواقب اجرای آن برنامه هم می‌اندیشند. این افراد کسانی هستند که هنر به پایان.
                    </p>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-3">
                    <h6 class="text-center">ما را در شبکه های اجتمایی دنبال کنید.</h6>
                    <div class="social-buttons mt-1">
                        @if(trim(\App\Helpers\getSetting('soc_in')) != '')
                            <a class="social-button social-button--instagram" aria-label="instagram" target="_blank"
                               href="{{\App\Helpers\getSetting('soc_in')}}">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if(trim(\App\Helpers\getSetting('soc_tg')) != '')
                            <a class="social-button social-button--telegram" aria-label="telegram" target="_blank"
                               href="{{\App\Helpers\getSetting('soc_tg')}}">
                                <i class="fab fa-telegram"></i>
                            </a>
                        @endif
                        @if(trim(\App\Helpers\getSetting('soc_wp')) != '')
                            <a class="social-button social-button--whatsapp" aria-label="whatsapp" target="_blank"
                               href="https://api.whatsapp.com/send/?phone={{urlencode(\App\Helpers\getSetting('soc_wp'))}}&text=%D8%A8%D8%A7%20%D8%B3%D9%84%D8%A7%D9%85%0A%D8%A7%D8%B2%20%D8%B3%D8%A7%DB%8C%D8%AA%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%B3%D9%81%D8%A7%D8%B1%D8%B4%20%D9%88%20%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C%20%D8%AA%D9%85%D8%A7%D8%B3%20%D9%85%DB%8C%DA%AF%DB%8C%D8%B1%D9%85&app_absent=0">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                        @if(trim(\App\Helpers\getSetting('soc_tw')) != '')
                            <a class="social-button social-button--twitter" aria-label="twitter" target="_blank"
                               href="{{\App\Helpers\getSetting('soc_tw')}}">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif
                        @if(trim(\App\Helpers\getSetting('soc_yt')) != '')
                            <a class="social-button social-button--youtube" aria-label="youtube" target="_blank"
                               href="{{\App\Helpers\getSetting('soc_yt')}}">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </footer>
    <!-- footer -->
</div>
<!-- top footer description -->
<!-- terms -->
<div class="footer-terms text-center mt-3">
    <p>
        {{\App\Helpers\getSetting('copyright')}}
        &copy; {{date('Y')}}
    </p>
</div>
<!-- terms -->

<input type="hidden" id="fav-toggle" value="{{route('fav.toggle','')}}">
@yield('js-content')
<script src="{{asset('js/theme.js')}}" defer></script>
@include('component.lang')
</body>
</html>
