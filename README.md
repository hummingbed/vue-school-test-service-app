##### About project
this is a project for Maruchi customer backend

##### Requirements
The minimum requirement by this project template that your Web server supports PHP 8.2

##### PHP and Composer
* [PHP 8.2.*](https://discussions.eramba.org/t/php8-2-update-source-code-installs/3093)
* [Composer](https://getcomposer.org/doc/00-intro.md#using-composer)

##### Project setup
- **clone repo**
- **create `.env` file and paste `.env.example` into `.env`**
- **update the value of the variables in the `.env` file**

```
composer install
```
##### generate APP_KEY in .env file
```
php artisan key:generate
```

##### serve app
```
php artisan serve
```
##### run migration
```
 php artisan migrate
```

##### seed database
```
 php artisan db:seed
```
