<div dir="rtl">
<div align="center">
    <img width="250" src="resources/images/xshop-logo.svg" alt="xShop logo">
</div>

# xShop/v2

> [!NOTE]
> xShop یک سیستم فروشگاه نوشته شده در لاراول با قابلیت سفارشی‌سازی فراوان

## امکانات نگارش جدید

- تغییرات اساسی در کنترل پنل
- یکپارچه‌سازی Laravel & vujs.js
- نمودارهای پیشرفته
- بهینه‌سازی سایت‌های چند زبانه و افزایش بهره‌وری هوش مصنوعی ترجمان
- اصلاح مشکلات تکنیکی
- کاهش سایز پروژه
- UI/UX شخصی‌سازی شده
- دوستانه تر شدن محیط توسعه

## نحوه نصب [ حالت توسعه دهنده ]

> [!مهم]  
> ابتدا یک دیتابیس درست کنیدد و سپس `.env.example` را به  `.env` تغییر دهید و  `.env` کارهای زیر به ترتیب مراحل اجرای
> پروژه روی لوکال هاست می‌باشد :

<div dir="ltr">

```bash
git clone https://github.com/4xmen/xshop.git
cd xshop
cp .env.example .env
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
php artisan serv

# to develop front-end

npm install -g yarn
yarn install
php artisan client
yarn dev
```
</div>

> [!TIP]
> اطلاعات ورود اولیه  : `developer@example.com` (به عنوان توسعه دهنده) یا `admin@example.com` (به عنوان مدیر) و
> گذرواژه : `password`

## افزودن تصاویر نمونه

- دانلود و آماده‌سازی تصاویر


<div dir="ltr">

```bash
php artisan seeding:prepare
 ```
</div> 


- ویا تصاویر خود را با پوشه مورد نظر در این مسیر کپی کنید: `database/seeders/images/`
- سپس یکی از مدل ها دلخواه را seed image کنید: [Group, Category, Post, Product, Slider]

<div dir="ltr">

```bash
php artisan seeding:image Product digital
```
</div>

یا برای همه مدل‌ها یک‌جا از دستور زیر استفاده کنید:

<div dir="ltr">

```bash
php artisan seeding:all digital
```
</div>

> شما ابتدا باید مدل را نوشته و سپس فولدر مورد نظر برای تصاویر را وارد کنید[bag, clothe, digital, sport, posts, makeup]
> همچنین می‌توانید یک پوشه درخواه پر از تصاویر jpg دلخواه را در آن پر کنید

## ملزومات

- php 8.2.x یا بالاتر با همراه افزونه‌ها [ `php-gd`, `sqlite3`, `php-soap`]
- mysql یا mariadb یا sqlite
- composer
- پیشنهاد می‌شود imagemagick برای افزایش راندمان تصاویر نصب کنید

## راهنمای انتشار

قویا پیشنهاد می‌کنیم از vps به جا میزبان اشتراکی استفاده کنید و بعد از ساختن دیتابیس دستورات زیر را اجرا کنید:

<div dir="ltr">

```bash
cd /home/[yourUsername]/[pathOfYourWebsitePublicHTML]
git clone  https://github.com/4xmen/xshop.git . # if this command not work make empty this folder
cp .env.example .env
nano .env # edit your config db, url, etc.
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php key:generate
npm install 
php artisan client
npm run build
```
</div>

## بهینه سازی سایت و آماده سازی نسخه نهایی

<div dir="ltr">

```bash
nano .env # make APP_DEBUG false, APP_ENV production
php artisan optimize
composer install --optimize-autoloader --no-dev
```
</div>

## اضافه کردن cron job

جهت اجرا کامل برنامه ها زمان‌دار فروشگاه باید یک دستور زیر رو بزنید:

<div dir="ltr">

```bash
crontab -e
```
</div>

و این خط رو اضافه کنید:

<div dir="ltr">

```bash
* * * * * cd /home/[yourusername]/[your-public-html-project-root] && php artisan schedule:run >> /dev/null 2>&1
```
</div>


## ساختن xController

درواقع xController یک کنترولر بسیار پیشرفته با همراه لاگ و CRUD برای توسعه آسان است با فرض زیر:
User [`model`]

<div dir="ltr">

```bash
php artisan make:xcontroller User
```
</div>

## make theme part

Theme part usable in area

PartName [`theme aprt name`]

segmentName [`group`, `category`, `preloader`, ...],

<div dir="ltr">

```bash
php artisan  make:part PartName segmentName
```
</div>

## client بهینه‌سازی فضای

برا بهینه سازی کلیه دارای‌های سایت `scss`,`js`,`css`


<div dir="ltr">

```bash
php artisan client
php artisan build
```
</div>

### توضیحات پرونده‌های قسمت قالب 

- PartName.php: `onCreate`, `onRemove`, `onMount` برای انجام اعمال قسمت
- PartName.blade.php: برای قرارگرفتن کد‌های blade code
- PartName.scss:برای افزودن ویژگی‌های scss
- PartName.js: برای افزودن javascript
- screenshot.png: و یک پیش‌نمایش از قسمت قالب

## Demo / دمو

> برای دیدن یک دموی آنلاین : <a href="https://xshop.xstack.ir/login">https://xshop.xstack.ir/</a>

### تصاویر محیطی

![1](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot1.png)

![2](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot2.png)

![3](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot3.jpg)

![4](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot4.png)

![5](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot5.jpg)

## دسترسی به نگارش xShop/v1

> [!هشدار]  
> xShop/v1 قابل دسترس در اینجا: <a href="https://github.com/4xmen/xshop.v1">https://github.com/4xmen/xshop.v1</a>


<p align="center"> 
   توسعه داده شده با محبت ! ❤️
</p>
</div>
