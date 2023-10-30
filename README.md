
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

## Have to Do

- [x] Employee Attendance management
- [ ] Category management
- [ ] Product management
- [ ] Manage Inventory Expenses
- [ ] POS management
- [ ] Stock management
- [ ] Order Invoice generate pdf
- [ ] User roles and permissions (Manager, Cashier)
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Loading components
- [ ] Adding Charts and Graphs
- [ ] Pickaday for date picking
- [ ] Sending notifications
- [ ] Product import and export from excel file
- [ ] Login using Email/Phone number
- [ ] Bulk deleting
- [ ] Trash deleting (delete forever)
- [ ] Log view
- [ ] Customize code for production
