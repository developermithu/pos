
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

Generate model helper by running ```php artisan ide-helper:models``` after migrating new models.

## Composer commands

- ```composer outdated``` display the all package available new version.
- ```composer show <package-name>``` to check existing packages version
- ```composer remove <package-name>``` to remove existing package


## Have to Do

- [x] Employee Attendance management
- [ ] Category management
- [x] Product management
  - [x] create
  - [x] edit
  - [x] delete
  - [x] show
  - [ ] adding attributes (kg, gm, cm)
  - [ ] import and export from excel file
- [x] Manage Inventory Expenses
- [x] POS management
- [ ] Stock management
- [x] Order Invoice generate pdf
- [ ] User roles and permissions (Manager, Cashier)
- [x] Adding page title
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Loading components
- [ ] Adding Charts and Graphs
- [ ] Pickaday for date picking
- [ ] Adding price mutator (get and set)
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Bulk deleting
- [x] Trash deleting (delete forever)
- [ ] Log view
- [ ] Customize code for production


## Roles Feature

- Super Admin can do anything
- Manager can view, edit, create, update and delete but **can not view cash information**
- Cashier can view everything

