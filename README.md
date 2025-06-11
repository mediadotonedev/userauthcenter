
# UserAuthCenter - Laravel User Authentication Package

UserAuthCenter is a comprehensive Laravel package designed to provide robust user authentication functionalities, including OTP (One-Time Password) and traditional password-based authentication. This package aims to simplify the integration of advanced authentication features into your Laravel applications.

## Table of Contents

-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Database Migrations](#database-migrations)
-   [Publishing Files](#publishing-files)
    -   [Configuration File](#configuration-file)
    -   [Controllers](#controllers)
    -   [Requests](#requests)
    -   [Rules](#rules)
    -   [Models](#models)
    -   [Services](#services)
    -   [Swagger Configuration](#swagger-configuration)
    -   [All Publishable Files](#all-publishable-files)
-   [Usage](#usage)
    -   [API Routes](#api-routes)
    -   [Extending Functionality](#extending-functionality)
-   [Contribution](#contribution)
-   [License](#license)

## Installation

To install UserAuthCenter, require it via Composer in your Laravel project:

```bash
composer require mediadotonedev/userauthcenter:dev-main
php artisan vendor:publish --tag=userauthcenter-config
php artisan vendor:publish --tag=userauthcenter-controllers
php artisan vendor:publish --tag=userauthcenter-requests
php artisan vendor:publish --tag=userauthcenter-rules
php artisan vendor:publish --tag=userauthcenter-migrations
php artisan migrate
php artisan vendor:publish --tag=userauthcenter-models --force
php artisan vendor:publish --tag=userauthcenter-services
php artisan l5-swagger:generate
```

After installing the package, Laravel will automatically discover the package's service provider. No manual registration is required for Laravel versions 5.5 and above.

## Configuration

The package comes with a configurable file `userauthcenter.php`. You can publish this configuration file to your application's `config` directory to customize its settings.

To publish the configuration file, run:

```bash
php artisan vendor:publish --tag=userauthcenter-config
```

This will copy `vendor/mediadotonedev/userauthcenter/src/config/userauthcenter.php` to `config/userauthcenter.php`.

## Database Migrations

This package includes its own database migrations for user-related tables or modifications. It's crucial to run these migrations to set up your database correctly.

First, you can publish the migrations to your application's `database/migrations` directory:

```bash
php artisan vendor:publish --tag=userauthcenter-migrations
```

After publishing, run your database migrations:

```bash
php artisan migrate
```

**Note:** If you already have a `users` table, the package's migration (`update_users_table.php`) might attempt to modify it. Review the migration file to ensure it aligns with your existing database schema.

## Publishing Files

UserAuthCenter allows you to publish several of its internal files to your application. This is useful if you need to modify or extend the package's core logic or components directly.

### Configuration File

As mentioned above, to publish the configuration file:

```bash
php artisan vendor:publish --tag=userauthcenter-config
```

### Controllers

To publish the `UserAuthController.php` to `app/Http/Controllers/`:

```bash
php artisan vendor:publish --tag=userauthcenter-controllers
```

### Requests

To publish all validation request files to `app/Http/Requests/`:

```bash
php artisan vendor:publish --tag=userauthcenter-requests
```

### Rules

To publish custom validation rules (e.g., `EmailOrIranianMobile.php`) to `app/Rules/`:

```bash
php artisan vendor:publish --tag=userauthcenter-rules
```

### Models

To publish the `User.php` model to `app/Models/`:

```bash
php artisan vendor:publish --tag=userauthcenter-models --force
```

**Important:** Publishing the `User.php` model might conflict with your existing `App\Models\User.php`. Exercise caution and merge changes manually if necessary, or consider using a different model name within your package if a direct conflict is undesirable.

### Services

To publish service classes (e.g., `UserAuthService.php`, `UserService.php`) to `app/Services/`:

```bash
php artisan vendor:publish --tag=userauthcenter-services
```

### Swagger Configuration

If your package includes Swagger/OpenAPI documentation, you can publish its configuration:

```bash
php artisan l5-swagger:generate
```

### All Publishable Files

To publish all the above-mentioned files (config, migrations, controllers, requests, rules, models, services, swagger config) with a single command:

```bash
php artisan vendor:publish --provider="Mediadotonedev\UserAuthCenter\UserauthcenterServiceProvider"
```

Or, if you define an `userauthcenter-all` tag in your ServiceProvider:

```bash
php artisan vendor:publish --tag=userauthcenter-all
```

### API Config

add environment packacage connect to api  append .env file.

```bash
USERAUTHCENTER_API_KEY=
USERAUTHCENTER_API_URL=
```

## Usage

### API Routes

The package provides its own API routes for authentication. These routes are automatically loaded by the package and do not overwrite your application's `routes/api.php`.

The API routes are defined in `vendor/mediadotonedev/userauthcenter/src/routes/userauthcenter_api.php`. You can inspect this file to see the available endpoints.

Typically, these routes would handle:

- User registration (with or without OTP)
- User login (password-based or OTP-based)
- OTP generation and verification
- Password reset functionalities

**Example:** If your package defines `/api/auth/register`, you can access it directly after installation.

### Extending Functionality

Since you can publish various components like controllers, requests, rules, and models, you have the flexibility to extend or override the package's default behavior by modifying the published files.

## Contribution

Feel free to contribute to the UserAuthCenter package. Bug reports, feature requests, and pull requests are welcome.

## License

The UserAuthCenter package is open-sourced software licensed under the MIT license.
