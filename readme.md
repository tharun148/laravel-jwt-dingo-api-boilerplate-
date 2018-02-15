<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Laravel Dingo API JWT Boilerplate

This laravel boilerplate use to build an API in seconds. In this I have done an AUTH modules

this boilerplate used below packages
- JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
- Dingo API - [dingo/api](https://github.com/dingo/api).


## Installation

 - first clone the repository by this command ```git clone https://github.com/tharun148/laravel-jwt-dingo-api-boilerplate```;
 - Move to project folder run ```composer install```
 - Create a .env file in root folder
 - Copy the .env.example file content to .env
 - In .env file give the application details
 - Generate application key by ```php artisan key:generate```
 - After run ```php artisan migrate``` for generating database migration
 - ```php artisan jwt:secret``` to generate jwt key in .env file

## AUTH Api details
  - POST api/auth/login, to do the login and get your access token;
  - POST api/auth/signup, to create a new user into your application;
  - POST api/auth/recovery, to recover your credentials;
  - POST api/auth/reset, to reset your password after the recovery;
  - POST api/auth/refresh, to refresh your token;
  - POST api/auth/logout, to remove the token;

## Feedback

For any questions or feedback, feel free to send me an email at [tharunkumar148@gmail.com](mailto:tharunkumar148@gmail.com).


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
