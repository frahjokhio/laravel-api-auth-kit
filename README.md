# Laravel API Auth Kit

A starter kit that gives you a quick and clean setup for building APIs in Laravel.  
You can use it with Next.js, React, mobile apps or any frontend framework.

This kit includes authentication out of the box and supports creating additional modules for your API.

---

## Features

- Fast setup to start building APIs  
- Built-in authentication using **Laravel Sanctum**  
- Pre-built Auth module with:
  - Register  
  - Login  
  - Get current user (me)  
  - Logout  
- Modular structure for clean and scalable API development  
- Full compatibility with the **Laravel Module Generator** package

---

## Module Generator Integration

This repository uses the **Laravel Module Generator** to structure the Auth module.  
You can use the same package to generate your own modules.

**Module Generator Package:**  
https://github.com/frahjokhio/laravel-module-generator

The generator creates everything for you, including controllers, services, repositories, requests, models, migrations and route files.

When your module is generated, you will find its routes here:
```
app/Modules/{ModuleName}/routes/api.php
```

To protect your module’s routes with authentication, wrap them inside the Sanctum middleware:

```php
Route::middleware('auth:sanctum')->group(function () {
    // api routes
});
```
## What You Get Out of the Box

After installing the kit:

- Authentication is ready to use
- API routes for register, login, me and logout already exist
- You can immediately start creating new API modules with the generator
- Clean separation of logic so your project stays organized as it grows

```
git clone https://github.com/frahjokhio/laravel-api-auth-kit.git
cd laravel-api-auth-kit
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

---

## Authentication Endpoints

Base path: `/api/auth`

| Endpoint    | Method | Description                     |
|-------------|--------|---------------------------------|
| `/register` | POST   | Create a new user               |
| `/login`    | POST   | Login user                      |
| `/me`       | GET    | Get current authenticated user  |
| `/logout`   | POST   | Logout user                     |

All protected endpoints use auth:sanctum.

---

## Creating Your Own Modules

Generate a new module:

```
php artisan make:module Product
```

Add Sanctum protection in your module’s route file:
```
app/Modules/Product/routes/api.php
```

```
Route::middleware('auth:sanctum')->group(function () {
    // product routes
    Route::apiResource(strtolower('Product'), ProductController::class);
});
```

Your module is ready.

---

### License

MIT