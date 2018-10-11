# bChat

## Setup Guide
1. Ensure that MySQL is running
2. Create the bChat database in the MySQL console using: 
```SQL
CREATE DATABASE bchat;
```
3. Create the bChat database user in the MySQL console using 
```SQL
CREATE USER 'bchatadmin'@'localhost' IDENTIFIED BY 'adminbchat';
````
4. Mac users need to run one more command in the MySQL console to allow Laravel to connect using:
```SQL
ALTER USER 'bchatadmin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'adminbchat';
```
5. Grant the bChat database user the required permissions in the MySQL console using 
```SQL
GRANT ALL PRIVILEGES ON bchat.* TO 'bchatadmin'@'localhost';
```
6. Install the project dependencies using 
```bash
composer install
```
7. Install the  initial database migrations using 
```bash
php artisan migrate:install
```
## Running the Project
After going through the setup guide, run the project by using:
```bash
php artisan serve
```
