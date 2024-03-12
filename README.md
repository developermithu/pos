
## Getting Started

```bash
git clone https://github.com/developermithu/zihad-plastic.git
cd zihad-plastic
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install && npm run dev
php artisan serve
```

## Hostinger Info

 ```composer --version``` will display composer version 1.0 but 
 ```php composer.phar --version``` will display latest version and by running ```php composer.phar``` we can modify composer version. 
When deploying production instead of **composer install --optimize-autoloader --no-dev** we have to run ```php composer.phar install --optimize-autoloader --no-dev```


Generate model helper: ```php artisan ide-helper:models``` 

## Composer Commands

- ```composer outdated``` display the all package available new version.
- ```composer show <package-name>``` to check existing packages version
- ```composer remove <package-name>``` to remove existing package

## Uses of Laravel Pint

- `pint --test` display code style issues 
- `pint` fix code style issues 
- `pint app/Models/User.php` fix code style issues on specific files or directories


## Have to 

When clear customer and supplier due have to update automatically sale status, purchase status, product qty as well along with payment status  

- [ ] fix show, edit, delete, restore, forcedelete (ulid)
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Customize code for production
- [ ] import and export from excel file
  

**May need to add**

when deleting **received purchase items** should we decrease product qty?

### Migration Tips in Production

1. Creating extra field in an existing table
   
`php artisan make:migration add_columnName_to_table_name`

```php
    if (!Schema::hasColumn('suppliers', 'ulid')) {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('ulid')->unique()->after('id');
        });
    }
```

2. Deleting existing table

`pam drop_table_name`

```php
    public function up(): void
    {
        Schema::dropIfExists('table_name');
    }
```

3. Modify existing table field

`pam modify_suppliers_table`

```php
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('ulid')->index()->change();
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('ulid')->index(false)->change();  // Revert the changes
        });
    }
```
