
<div align="center">
    <img width="250" src="resources/images/xshop-logo.svg" alt="xShop logo">
</div>

# xShop/v3

> [!NOTE]
> xShop is an open-source shop developed in Laravel, highly customizable!

## New Features

- Dashboard panel improvements
- Integration of Vue.js and Laravel
- Advanced charts
- Better customization with AI & language support
- Fixed technical issues
- Project size compression
- More specific UI/UX
- Developer-friendly
- Custom theme design
- WordPress migration
- Easy support for multilingual (rtl-ltr) websites
- A powerful SEO foundation means users never have to worry about technical SEO issues.


#### Default supported payment gateways:
<div style="background: #ffffff;padding:1rem 7px; display: flex; justify-content: space-evenly;">
<img src="thirdparty/assets/paypal.svg" style="height: 48px"  alt="paypal">
<img src="thirdparty/assets/zarinpal.svg" style="height: 48px"  alt="zarinpal">
<img src="thirdparty/assets/zibal.svg" style="height: 48px" alt="zibal">
</div>

## Documentation

- [📄 **Full Documentation** 📄](https://4xmen.github.io/xshop/#/)
- [🇮🇷 Persian README](README-fa.md)

## Installation [Development Mode]

> [!IMPORTANT]  
> Create a new database and rename `.env.example` to `.env`, then update your `.env` configurations. Run the following commands:

```bash
git clone https://github.com/4xmen/xshop.git
cd xshop
cp .env.example .env
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
php artisan serve

# To develop front-end
npm i
php artisan client
npm install @rollup/rollup-win32-x64-msvc # Windows only, if the below line does not work
npm run dev

# Or with yarn

yarn install
php artisan client
yarn add @rollup/rollup-win32-x64-msvc # Windows only, if the below line does not work
yarn dev
```

> [!TIP]  
> Default admin emails are: `developer@example.com` (developer) or `admin@example.com` (admin)  
> Default password: `password`

## Image Seeding

- Download and prepare images:  
```bash
php artisan seeding:prepare
```
- Then copy your image folder to `database/seeders/images/`
- Seed images for models: [Group, Category, Post, Product, Slider]  

```bash
php artisan seeding:image Product digital
```

Or to seed all models:

```bash
php artisan seeding:all digital
```

> The first parameter is the model name; the second is the image seeder directory. Available directories: `[bag, clothe, digital, sport, posts, makeup]`  
> You can create your own directory, add images to it, and use it with the image seeder.

## Requirements

- PHP 8.2.x or above with extensions: `php-gd`, `sqlite3`, `php-soap`
- MySQL, MariaDB, or SQLite
- Composer
- Recommended: Install ImageMagick on the server for better image performance

## Deployment Guide

We recommend deploying xShop on a VPS. Create a database and run the following commands:

```bash
cd /home/[yourUsername]/[pathToYourWebsitePublicHTML]
git clone https://github.com/4xmen/xshop.git .  # If this command doesn’t work, empty this folder first
cp .env.example .env
nano .env # Edit your DB config, URL, etc.
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
npm install 
php artisan client
npm run build
```

## Optimize for Production

```bash
nano .env # Set APP_DEBUG=false, APP_ENV=production
php artisan optimize
composer install --optimize-autoloader --no-dev
```

## Add Cron Job

Add a crontab entry for your project:

```bash
crontab -e
```

Add this line:

```bash
* * * * * cd /home/[yourusername]/[your-public-html-project-root] && php artisan schedule:run >> /dev/null 2>&1
```

## Create xController

Create a controller with logging and semi-automatic CRUD with logs.  
Usage: [`model`]

```bash
php artisan make:xcontroller User
```

## Create Theme Part

Create a reusable theme part in a specific area.

Parameters:  
PartName [`theme part name`]  
segmentName [`group`, `category`, `preloader`, ...]

```bash
php artisan make:part PartName segmentName
```

## Client Optimization

Optimize client assets: `scss`, `js`, `css`

```bash
php artisan client
php artisan build
```

### Theme Parts Files

- `PartName.php`: Contains `onCreate`, `onRemove`, `onMount` actions for the theme part  
- `PartName.blade.php`: Blade template for the theme part  
- `PartName.scss`: SCSS styles for the theme part  
- `PartName.js`: JavaScript for the theme part  
- `screenshot.png`: Screenshot preview of the theme part

## Demo

> Online demo available here: <a href="https://xshop.xstack.ir/login">https://xshop.xstack.ir/</a>


## How to migrate from WordPress & WooCommerce to xShop?

This is done in several steps:

- First install xShop following the steps described above (preferably on localhost).
- Then install the xshift plugin (found in the `thirdparty` folder) on your WordPress site.
- Next, run the following commands inside the xshop folder:

```
php artisan xshift group http://wp.test/
php artisan xshift post http://wp.test/
php artisan xshift catgory http://wp.test/
php artisan xshift product http://wp.test/
```

Replace `http://wp.test/` with your old website’s URL.  
If xshop does not allow data transfer and requires an empty database, run:

```
php artisan xshift clear
```

> Important notes: the above clear command will delete (truncate) all content and product data on your current server.

> Note: migration commands may take from 1 minute to several hours depending on the amount of content on the old site, especially the number of images.


### Screenshots

![1](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot1.png)

![2](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot2.png)

![3](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot3.jpg)

![4](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot4.png)

![5](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot5.jpg)

## Access to xShop/v1

> [!WARNING]  
> xShop/v1 is available here: <a href="https://github.com/4xmen/xshop.v1">https://github.com/4xmen/xshop.v1</a>

<p align="center"> 
    Developed with ❤️!
</p>
