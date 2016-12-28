# Roles and Permissions

- [Instalation](#nstalation)
	- [Composer](#composer)
	- [Service provider](#service-provider)
	- [Migrations](#migrations)
	- [User trait](#user-trait)
	- [Middleware](#middleware)



## Instalation

For you can install this package. You should to follow the next steps.

	
### Composer

For a installation package you can use the composer command 

composer require yasser/laravel-roles

or you can pull this package in through Composer file

```js
{
	"require": {
		...
		"yasser/laravel-roles": "^0.1.0"
	}
}
```

### Service Provider

Add the package to your application service providers in `config/app.php` file.

```php
'providers' => [
		...
		/*
         * Package Service Providers...
         */

        Yasser\Roles\RolesServiceProvider::class,
		
		/*
         * Application Service Providers...
         */
        ...
],

```

### Migrations

Excecute this command in your console to add migrations files to a project

	php artisan vendor:publish --provider="Yasser\Roles\RolesServiceProvider" --tag=migrations

and also run the migrations

	php aritsan migrate

### User trait

Include `HasRolesRelations` trait inside your `User` model.

```php

use Yasser\Roles\Traits\HasRolesRelations;

class User extends Authenticatable
{
    use Notifiable, HasRolesRelations;


```

### Middleware

Add the middleware `VerifyPermission` into app/Http/kernel.php file.

```php

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
    	...
		'verify' => \Yasser\Roles\Middlewares\VerifyPermission::class,
    ],

```