<div align="center">
    <img width="250" src="resources/images/xshop-logo.svg" alt="xShop logo">
</div>

# xShop/v2

> [!NOTE]
> xShop is an open source shop developed in laravel, very customizable!

## New Features:

- Dashboard panel changes
- Integration of Vue.js and laravel
- Advanced charts
- Better customizable with AI & languages
- Fixed Technical issues
- Project size compression
- UI/UX is more specific
- Developer Friendlier

## Access to xShop/v1
> [!WARNING]  
> xShop/v1 available here: <a href="https://github.com/4xmen/xshop.v1">https://github.com/4xmen/xshop.v1</a>


## Installation

> [!IMPORTANT]  
> Create new database and rename `.env.example` to `.env` then update you `.env` configs so run this commands:

```bash
git clone https://github.com/4xmen/xshop.git
cd xshop
composer install
php artisan migrate:fresh --seed
php artisan storage:link
php artisan key:generate
php artisan serv
```

> [!TIP]
> Default admin email is : `developer@example.com` (developer) or `admin@example.com` (admin) and default password is: `password`


## image seeding 

- Download & prepare images 
```bash
php artisan seeding:prepare
 ```
- Seeding image for models: [Group, Category, Post, Product, Slider] 
```bash
php artisan  seeding:image Product digital
```
> First parameter is Model, Second is image seeder directory available [bag, clothe, digital, sport, posts, makeup]
> You can create your directory and put your image into new directory then use image seeder

## Requirement

- php 8.3.9 [ `php-gd`, `sqlite3`, `php-soap` ]
- mysql or mariadb
- composer

## Deploy guide

We recommend deploy xShop on VPS, so create database and run this commands:

```bash
cd /home/[yourUsername]/[pathOfYourWebsitePublicHTML]
git clone  https://github.com/4xmen/xshop.git . # if this command not work make empty this folder
cp .env.example .env
nano .env # edit your config db, url, etc.
composer install
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=SettingSeeder
nano .env # make APP_DEBUG false, APP_ENV production
php artisan storage:link
php key:generate
composer install --optimize-autoloader --no-dev
```

## make xController

Controller with log and semi-automatic CURD with logs  
User [`model`]

```bash
php artisan make:xcontroller User
```

## make theme part

Theme part usable in area

PartName [`theme aprt name`]

segmentName [`group`, `category`, `preloader`, ...],

```bash
php artisan  make:part PartName segmentName
```

## client optimize

Optimize client assets, `scss`,`js`,`css`

```bash
php artisan  client
```

### theme parts file

- PartName.php: `onCreate`, `onRemove`, `onMount` actions of theme part
- PartName.blade.php: your theme part blade code
- PartName.scss: your theme part scss
- PartName.js: your theme part javascript
- screenshot.png: screenshot preview of theme part

### Screenshots

![1](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot1.png)

![2](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot2.png)

![3](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot3.jpg)

![4](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot4.png)

![5](https://raw.githubusercontent.com/A1Gard/xshop-installer-assets/master/screenshots/xshop-screenshot5.jpg)


<p align="center"> 
    Developed With Love ! ❤️
</p>
