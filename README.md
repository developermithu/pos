
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

## Composer commands

- ```composer outdated``` display the all package available new version.
- ```composer show <package-name>``` to check existing packages version
- ```composer remove <package-name>``` to remove existing package


## Have to Do

- [ ] Product management
  - [ ] import and export from excel file
- [ ] Stock management
- [ ] Backup database 
- [ ] Custom Error page
- [ ] Sending notifications
- [ ] Login using Email/Phone number
- [ ] Log view
- [ ] Customize code for production

