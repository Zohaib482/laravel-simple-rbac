# Laravel Simple RBAC

A simple, lightweight **Role-Based Access Control (RBAC)** package for Laravel with built-in authentication and email verification support.

## Features

- Role & permission management (many-to-many)
- Built-in authentication + email verification flow
- Bootstrap 5 styled auth views (login, register, verify-email, dashboard)
- Middleware: `role:admin`, `permission:manage-users`, etc.
- Blade directives: `@role`, `@permission`, `@anyrole`
- Easy integration via trait on User model
- Configurable (user model, default role, redirect paths)

## Requirements

- PHP ^8.2
- Laravel ^12.0

## Installation

1. Install the package via Composer:

   ```bash
   composer require zohaib482/laravel-simple-rbac
   ```
2. Publish configuration, views and migrations,Seeder:

   ```bash
   php artisan vendor:publish --tag=simple-rbac-config
   php artisan vendor:publish --tag=simple-rbac-views
   php artisan vendor:publish --tag=simple-rbac-migrations
   ```
## Seeding Roles and Permissions

After publishing and running migrations, you need to seed the default roles and permissions:

**Publish the seeder** (if not already published):
   ```bash
   php artisan vendor:publish --tag=simple-rbac-seeders
   ```
Run the seeder:

   ```php
   php artisan db:seed --class=RbacSeeder
   ```
Or add it to your DatabaseSeeder.php:

   ```php
   public function run(): void
    {
        $this->call([
            RbacSeeder::class,
            // Your other seeders...
        ]);
    }
    ```

3. Run migrations and seed default roles/permissions:

   ```bash
   php artisan migrate

4. Add the HasRoles trait to your User model (app/Models/User.php):

   ```php
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Zohaib482\SimpleRbac\Traits\HasRoles;

    class User extends Authenticatable implements MustVerifyEmail
    {
        use HasRoles;

        // ... other traits and properties
    }
   ```

## Quick Usage Examples
## Assign roles

   ```php
    $user->assignRole('admin');
    $user->assignRole('editor', 'moderator'); // multiple
   ```

## Check roles & permissions

   ```php
   $user->hasRole('admin');                        // true/false
    $user->hasAnyRole(['admin', 'editor']);         
    $user->hasPermissionTo('manage-users');        
   ```
## Protect routes with middleware

   ```php
    Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
    });
   ```
## Blade directives

   ```php
   @role('admin')
    <p>Welcome, Administrator!</p>
   @endrole

   @permission('manage-users')
    <a href="/users">Manage Users</a>
   @endpermission
   ```
## Configuration
## After publishing, edit config/simplerbac.php:

   ```php
   return [
    'user_model'           => App\Models\User::class,
    'default_role'         => 'user',
    'redirect_after_login' => '/dashboard',
    'email_verification'   => true,
];
   ```
