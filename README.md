
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


## Have to Do

- [ ] Product Stock/Qty management
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Customize code for production
- [ ] import and export from excel file
  

**May need to add**
purchase_price, sale_price, unit_cost field on **purchase_items** and **sale_items** table.

when deleting **received purchase items** should we decrease product qty?

have to fix qty after sale and purchase **qty** maybe int or float

