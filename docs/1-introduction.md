# Introduction

## What is xShop?

> xShop is an open source shop developed in laravel, very customizable! Easy site design.
> By the way is very fast development.
> Support multilanguage sites [RTL & LTR support]

### version 2 new features

-  Dashboard panel changes
-  Integration of Vue.js and laravel
-  Advanced charts
-  Better customizable with AI & languages
-  Fixed Technical issues
-  Project size compression
-  UI/UX is more specific
-  Developer Friendlier

## Requirement

- php 8.2.x or above [ php-gd, sqlite3, php-soap, php-zip ]
- mysql or mariadb or sqlite
- composer
- recommends install imagemagick on server to more image performance [ to generate webp images ]

## Quick Start



### Installation [ Development mode ]

> [!IMPORTANT]  
> Create new database and rename `.env.example` to `.env` then update you `.env` configs so run this commands:

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
npm i
php artisan client
npm install @rollup/rollup-win32-x64-msvc # just for windows if the below line dose not work
npm run dev

# or with yarn

yarn install
php artisan client
yarn add @rollup/rollup-win32-x64-msvc # just for windows if the below line dose not work
yarn dev

```

> [!TIP]
> Default admin email is : `developer@example.com` (developer) or `admin@example.com` (admin) and default password is: `password`


### Deploy guide

We recommend deploy xShop on VPS, so create database and run this commands:

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