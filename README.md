# bChat
To fill the desire for simplicity and security in users who have grown weary of convoluted modern communication software by providing a fast, simple, and secure solution.

## Requirements
1. homebrew `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
2. composer `brew install composer`
3. yarn `brew install yarn`
4. php `brew install php` and `brew services start php` to start the service
5. mySQL `brew install mysql` and `brew services start mysql` to start the service


## Setup Guide
1. Ensure that MySQL, homebrew, and php are running by using `brew services list`
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
8. Install yarn requirements
```
yarn install
```
## Running the Project
After going through the setup guide, run the project by using:
```bash
php artisan serveall
```
and in a second window
```bash
yarn watch
```
