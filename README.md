<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prerequisites
#### Before starting, ensure you have the following installed:

1. Composer
2. PHP >= 8.2
3. Node.js
4. database server is mysql

## Instalation Guide
#### Clone repository
````bash
git clone https://github.com/adityaajinug/poliklinik-web

cd poliklinik-web
````
#### Install Dependencies
````bash
composer install

npm install
````
#### Set Environtment Variable
````bash
cp .env.example .env

````
create db and copy paste this or adjustment
````
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=poliklinik
DB_USERNAME=root
DB_PASSWORD=
````
#### Generate App Key
```bash
php artisan key:generate
```

#### Run migration
```bash
php artisan migrate
```
#### Start Application
```bash
php artisan serve
```
if you on development run also in new terminal
```bash
npm run dev
```