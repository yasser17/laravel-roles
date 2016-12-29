# Roles and Permissions
[![Build Status](https://travis-ci.org/yasser17/laravel-roles.svg?branch=master)](https://travis-ci.org/yasser17/laravel-roles)

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
	- [Check if a user has a role](#check-if-a-user-has-a-role)
	- [Check if a user has a permission](#check-if-a-user-has-a-permission)
	- [Blade directives](#blade-directives)
	- [Middleware functions](#middleware-functions)



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
		"yasser/laravel-roles": "^0.1.2"
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
        'check' => \Yasser\Roles\Middlewares\VerifyRole::class,
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

You can attach one permition to a role 

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

or you can detach many permissions from a role

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

### Check if a user has a role

```php
    $adminRole = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    $user->checkRole('admin'); //return true or false
```

### Check if a user has a permission

```php
    $createPermission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create'
    ]);
    
    $user->canDo('user.create');
```

### Blade directives

```blade
    $role = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);

    @checkRole('admin')
    ...
    @endCheckRole
    
    $createPermission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create'
    ]);
    
    @canDo('user.create')
        <a href="/users/create">Create a user</a>
    @endCanDo
```

### Middleware functions

```php
    $role = Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
    ]);
    
    Route::get('user/create', ...)->middleware('ckeck:admin');
```

```php
    $createPermission = Permission::create([
        'name' => 'Create Users',
        'slug' => 'user.create'
    ]);
    
    Route::get('/user/create', ... )->middleware('verify:user.create');
```
