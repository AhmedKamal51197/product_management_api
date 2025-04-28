# Laravel Project

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This project is built using the **Laravel** framework, a powerful web application framework with expressive, elegant syntax. This repository contains the base structure and code for building modern web applications using Laravel.

## Prerequisites

Before running this project, ensure the following software is installed on your local machine:

- **PHP** >= 8.1
- **Composer** (Dependency Manager)
- **MySQL** or **SQLite** (or any database you prefer)
- **Node.js** and **npm** (for frontend dependencies)

## Installation

Follow these steps to get your project up and running locally:

### 1. Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/AhmedKamal51197/product_management_api.git
cd product_management_api
composer install
cp .env.example .env
php artisan key:generate
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
php artisan migrate
php artisan db:seed
php artisan serve

