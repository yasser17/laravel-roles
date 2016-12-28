# Roles and Permissions

- [Installation](#installation)
	- [Composer](#composer)
	- [Service provider](#service-provider)
	- [Migrations](#migrations)
	- [User trait](#user-trait)
	- [Middleware](#middleware)
- [Usage](#usage)
	- [Create Permissions](#create-permissions)
	- [Create Roles](#create-roles)
	- [Attach and Detach Permissions to a role](#attach-and-detach-permissions-to-a-role)
	- [Attach and Detach Role to a user](#attach-and-detach-role-to-a-user)



## Installation

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

}
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

## Usage

### Create Permissions

```php
	$permission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create',
        'description' => '', //optional
        'model' => '' //optional
    ]);
```

### Create Roles

```php
	$adminRole = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
        'description' => ''//optional
    ]);
```

### Attach and Detach Permissions to a role

You can attach one permitions to a role 

```php
	$createPermission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create',
        'description' => '', //optional
        'model' => '' //optional
    ]);

    $role = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    $role->attachPermission($createPermission);
```

or you can attach many permitions to a role

```php
	$createPermission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create'
    ]);

	$deletePermission = Permission::create([
        'name' => 'Delete user',
        'slug' => 'user.delete'
    ]);

    $role = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    $role->attachPermissions([$createPermission, $deletePermission]);
```

Detach a one permission from a role

```php
	$role->detachPermission($createRole);
```

or you can detach many permission from a role

```php
	$role->detachPermissions([$createPermission, $deletePermission])
```

### Attach and Detach Role to a user

Attach a Role to a user

```php
	$role = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    $user->attachRole($role)
```

Attach many roles to a user

```php
	$adminRole = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    $operatorRole = Role::create([
        'name' => 'Operator',
        'slug' => 'operator',
    ]);

    $user->attachRoles([$adminRole, $operatorRole]);
```

Detach a role from a user

```php
	$user->detachRole($role)
```

Detach many roles from a user

```php
	$user->detachRoles([$adminRole, $operatorRole])
```


