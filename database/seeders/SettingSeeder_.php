<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $s = new \App\Setting();
        $s->section = '0seo';
        $s->key = 'keywords';
        $s->type = 'text';
        $s->title = 'seo keyword';
        $s->value = 'shop, gold, mah gallery';
        $s->save();
        $s = new \App\Setting();
        $s->section = '0seo';
        $s->key = 'desc';
        $s->type = 'text';
        $s->title = 'seo description';
        $s->value = 'Mah gallery best shop for shop gold';
        $s->save();
//        //
        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'price';
        $s->type = 'text';
        $s->title = 'قیمت طلا';
        $s->value = '12000000';
        $s->save();

        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'tel';
        $s->type = 'text';
        $s->title = 'تلفن';
        $s->value = '+98 21 98765432';

        $s->save();

        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'whatsup';
        $s->type = 'text';
        $s->title = 'WhatsApp';
        $s->value = '+98936123456';
        $s->save();
//
        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'whatsup2';
        $s->type = 'text';
        $s->title = 'WhatsApp2';
        $s->value = '+98936123456';
        $s->save();

        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'pic[left]';
        $s->type = 'image';
        $s->title = 'عکس سمت راست';
        $s->value = null;
        $s->save();

        $s = new \App\Setting();
        $s->section = '1top-menu';
        $s->key = 'pic[right]';
        $s->type = 'image';
        $s->title = 'عکس سمت چپ';
        $s->value = null;
        $s->save();
        $s = new \App\Setting();
        $s->section = 'footer';
        $s->key = 'footer-sec1';
        $s->type = 'category';
        $s->title = 'پانویس قسمت اول';
        $s->value = 1;
        $s->save();
        $s = new \App\Setting();
        $s->section = 'footer';
        $s->key = 'footer-sec2';
        $s->type = 'category';
        $s->title = 'پانویس قسمت دوم';
        $s->value = 1;
        $s->save();
        $s = new \App\Setting();
        $s->section = 'footer';
        $s->key = 'footer-sec3';
        $s->type = 'editor';
        $s->title = 'پانویس قسمت سوم';
        $s->value = 'کلیه حقوق برای مَه‌گالری محفوظ است &copy; 2020';
        $s->save();
//
        $s = new \App\Setting();
        $s->section = 'footer';
        $s->key = 'footer-copyright';
        $s->type = 'text';
        $s->title = 'کپی رایت';
        $s->value = 'کلیه حقوق برای مَه‌گالری محفوظ است &copy; 2020';
        $s->save();
//








//
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-title-1';
//        $s->type = 'text';
//        $s->title = 'عنوان ۱';
//        $s->value = 'درباره دکتر منتظری';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-text-1';
//        $s->type = 'editor';
//        $s->title = 'متن ۱';
//        $s->value = 'دکتر روشنک منتظری هدشی؛ در کنکور سراسری سال 1383 در رشته دندانپزشکی دانشگاه تهران پذیرفته شد. ایشان بعد از گذراندن دوره 3 ساله رزیدنتی و دریافت بورد تخصصی کودکان در سال 1393 مشغول به فعالیت خود به عنوان هیات علمی در بخش کودکان و همچنین فعالیت درمانی در شهر تهران شدند.';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-title-2';
//        $s->type = 'text';
//        $s->title = 'عنوان ۲';
//        $s->value = 'خدمات بیهوشی کودکان';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-text-2';
//        $s->type = 'editor';
//        $s->title = 'متن ۲';
//        $s->value = 'دکتر روشنک منتظری هدشی؛ در کنکور سراسری سال 1383 در رشته دندانپزشکی دانشگاه تهران پذیرفته شد. ایشان بعد از گذراندن دوره 3 ساله رزیدنتی و دریافت بورد تخصصی کودکان در سال 1393 مشغول به فعالیت خود به عنوان هیات علمی در بخش <br > <a href="#" class="btn btn-outline-light float-left">
//                        بیشتر بخوانید
//                    </a>';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-title-3';
//        $s->type = 'text';
//        $s->title = 'عنوان ۳';
//        $s->value = 'ساعات کاری مطب';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '2sec2';
//        $s->key = 'sec2-text-3';
//        $s->type = 'editor';
//        $s->title = 'متن ۳';
//        $s->value = '<ul>
//                        <li>
//                        <span>
//                            شنبه
//                        </span>
//                            <b>
//                                13-17
//                            </b>
//                        </li>
//                        <li>
//                        <span>
//                            یکشنبه
//                        </span>
//                            <b>
//                                13-17
//                            </b>
//                        </li>
//                        <li>
//                        <span>
//                            دوشنبه
//                        </span>
//                            <b>
//                                13-17
//                            </b>
//                        </li>
//                    </ul>';
//        $s->save();
//
//        $s = new \App\Setting();
//        $s->section = '3sec3';
//        $s->key = 'sec3-title';
//        $s->type = 'text';
//        $s->title = ' عنوان بخش دوم';
//        $s->value = 'برای شاد کردن دنیا مهمترین چیزِ مورد نیاز هوشمندی است.';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '3sec3';
//        $s->key = 'sec3-text';
//        $s->type = 'longtext';
//        $s->title = ' متن بخش دوم';
//        $s->value = 'افراد گروه سوم از اهمیت به پایان رساندن آگاه هستند. آنها با تفکر منطقی، طرحی روشن ارائه می‌کنند. آنها نه تنها برای پایان دادن به پروژه‌ی خود در آینده برنامه ریزی می‌کنند، بلکه به تمام نتایج و عواقب اجرای آن برنامه هم می‌اندیشند. این افراد کسانی هستند که هنر به پایان رساندن را می‌دانند.';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '3sec3';
//        $s->key = 'sec3-category';
//        $s->type = 'category';
//        $s->title = 'بخش دوم سرفصل';
//        $s->value = '8';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '4sec';
//        $s->key = 'sec4-category';
//        $s->type = 'category';
//        $s->title = 'بخش سوم سرفصل';
//        $s->value = '2';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '5sec';
//        $s->key = 'sec5-category';
//        $s->type = 'category';
//        $s->title = 'بخش چهارم سرفصل';
//        $s->value = '9';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '6sec';
//        $s->key = 'sec6-category';
//        $s->type = 'category';
//        $s->title = 'بخش پنجم سرفصل';
//        $s->value = '10';
//        $s->save();
//
//        $s = new \App\Setting();
//        $s->section = '6sec';
//        $s->key = 'pic[side]';
//        $s->type = 'image';
//        $s->title = 'بخش پنجم عکس کنار';
//        $s->value = null;
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '6sec';
//        $s->key = 'pic[parallax]';
//        $s->type = 'image';
//        $s->title = 'عکس پارلاکس';
//        $s->value = null;
//        $s->save();
//
//        $s = new \App\Setting();
//        $s->section = '7sec';
//        $s->key = 'sec7-category';
//        $s->type = 'category';
//        $s->title = 'بخش ششم سرفصل';
//        $s->value = '8';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = '8sec';
//        $s->key = 'sec8-category';
//        $s->type = 'category';
//        $s->title = 'بخش آینده سرفصل';
//        $s->value = '9';
//        $s->save();
//
//
//        $s->section = 'footer';
//        $s->key = 'footer-copyright';
//        $s->type = 'text';
//        $s->title = 'کپی رایت';
//        $s->value = 'کلیه حقوق برای دکتر منتظری محقوظ است &copy; 2020';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-title-1';
//        $s->type = 'text';
//        $s->title = 'عنوان 1';
//        $s->value = 'درباره دکتر منتظری';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-text-1';
//        $s->type = 'editor';
//        $s->title = 'متن 1';
//        $s->value = 'دکتر روشنک منتظری هدشی؛ در کنکور سراسری سال 1383 در رشته دندانپزشکی دانشگاه تهران پذیرفته شد. ایشان بعد از گذراندن دوره 3 ساله رزیدنتی و دریافت بورد تخصصی کودکان در سال 1393 مشغول به فعالیت خود به عنوان هیات علمی در بخش کودکان و همچنین فعالیت درمانی در شهر تهران شدند.';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-title-2';
//        $s->type = 'text';
//        $s->title = 'عنوان 2';
//        $s->value = 'درباره دکتر منتظری';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-text-2';
//        $s->type = 'editor';
//        $s->title = 'متن 2';
//        $s->value =  '<ul class="ulist">
//                    <li>
//                        <a href="" class="text-light">تست شماره 1</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 2</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 3</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 4</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 5</a>
//                    </li>
//                </ul>';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-title-3';
//        $s->type = 'text';
//        $s->title = 'عنوان 3';
//        $s->value = 'درباره دکتر منتظری';
//        $s->save();
//
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-text-3';
//        $s->type = 'editor';
//        $s->title = 'متن 3';
//        $s->value =  '<ul class="ulist">
//                    <li>
//                        <a href="" class="text-light">تست شماره 1</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 2</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 3</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 4</a>
//                    </li>
//                    <li>
//                        <a href="" class="text-light">تست شماره 5</a>
//                    </li>
//                </ul>';
//        $s->save();

//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-title-4';
//        $s->type = 'text';
//        $s->title = 'عنوان 4';
//        $s->value = 'درباره دکتر منتظری';
//        $s->save();
//        $s = new \App\Setting();
//        $s->section = 'footer';
//        $s->key = 'footer-text-4';
//        $s->type = 'editor';
//        $s->title = 'متن 4';
//        $s->value = 'دکتر روشنک منتظری هدشی؛ در کنکور سراسری سال 3383 در رشته دندانپزشکی دانشگاه تهران پذیرفته شد. ایشان بعد از گذراندن دوره 3 ساله رزیدنتی و دریافت بورد تخصصی کودکان در سال 3393 مشغول به فعالیت خود به عنوان هیات علمی در بخش کودکان و همچنین فعالیت درمانی در شهر تهران شدند.';
//        $s->save();

    }
}
