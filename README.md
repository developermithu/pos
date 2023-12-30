
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

By default ```composer --version``` will display composer version 1.0 but runing ```php composer.phar --version``` will display latest version and by running ```php composer.phar``` we can modify composer version. 
When deploying production instead of **composer install --optimize-autoloader --no-dev** we have to run ```php composer.phar install --optimize-autoloader --no-dev```


Generate model helper by running ```php artisan ide-helper:models``` after migrating new models.

## Composer commands

- ```composer outdated``` display the all package available new version.
- ```composer show <package-name>``` to check existing packages version
- ```composer remove <package-name>``` to remove existing package


## Have to Do

- [x] Employee Attendance management
- [ ] Category management
- [ ] Product management
  - [ ] adding attributes (kg, gm, cm)
  - [ ] import and export from excel file
- [x] Manage Inventory Expenses
- [ ] Stock management
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Loading components
- [ ] Adding Charts and Graphs
- [ ] Pickaday for date picking
- [ ] Adding price mutator (get and set)
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Bulk deleting
- [ ] Log view
- [ ] Customize code for production


## Roles Feature

- Super Admin can do anything
- Manager can view, edit, create, update and delete but **can not view cash information**
- Cashier can view everything without pos


## New Models

- account management lagbe ?
- cashbook ki ki lagbe ?
- store_id lagbe ?
- payment ki sob cash hoy na bank ?

1. Account
  - id
  - name
  - account_no
  - description
  - initial_balance
  - total_balance
  - credit
  - debit
  - balance
  - is_default
  - is_active


2. CashbookEntry 
  - id
  - store_id ?
    - id
    - name
    - address
    - deposit_balance
  - account_id
  - description
  - folio ?
  - type (deposit/expense)
  - amount  