
## Getting Started

```bash
git clone https://github.com/developermithu/zihad-plastic.git
cd zihad-plastic
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
yarn install && yarn dev
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

- [ ] Backup database 
- [ ] Custom Error page
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Log view
- [ ] Customize code for production
- [ ] import and export from excel file
  

**May need to add**
purchase_price, sale_price, unit_cost field on **purchase_items** and **sale_items** tabe.


## Must do 

- [ ] Product Stock/Qty management
  

**Customer/Supplier**
- deposit
- expense

customer deposit balance = $customer->deposit - $customer->expense;

when generating sale if **pay_by deposit** then 
$customer->expense += $sale->paid_amount;

**Deposit Model**

- id
- customer_id (nullable)
- supplier_id (nullable)
- amount
- note (nullable)

**Overtime**

- id
- employee_id
- hours_worked
- rate_per_hour
- total_amount
- date

have to add **is_active** field to **employees** table