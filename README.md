# Features
- Role Based Access Control
- Responsive Design
- Modal Form
- Light/Dark Mode
- Toast Notification
- Datatable Serverside
- Reusable Component base on Primevue
# Requirements
- PHP 8.2
- Composer
- Mysql

# Installation
``` bash
git clone https://github.com/slametriky/laravelsakai.git
cd laravelsakai
composer install
npm install
cp .env.example .env
php artisan key:generate

SETTING UP DB CONNECTION IN .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sakai
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate:fresh --seed

START THE SERVER
npm run dev
php artisan serve
```
## Login With
### Superadmin
``` bash
email : superadmin@superadmin.com
password : superadmin
```
### Admin
``` bash
email : admin@admin.com
password : admin
```
### Operator
``` bash
email : operator@operator.com
password : operator

# Note
If you find some bug please create the issue or contact me on gmail: riyanriky@gmail.com