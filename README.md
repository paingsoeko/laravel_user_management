# paingsoeko/laravel_user_management


# Usage
## 1: Project Setup
```bash
  git clone https://github.com/paingsoeko/laravel_user_management.git
```
```bash
  cd laravel_user_management
```

## 2: Database
- Rename `.env.example` file to `.env`inside your project root and fill the database information.

- Run `composer install` or ```php composer.phar install```

- Connect your database in .env file


### Database migration and default data seeding
```bash
  php artisan migrate:fresh --seed
```
### key generate
```bash
  php artisan key:generate
```
## 3: Run project
```bash
   php artisan serve
```


###  Default Account Info
```info
    username=admin
    password=picosbs
```
