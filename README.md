# bChat
**About**:
- bChat is a chat platform which allows users to create simple and secure self-deleting chat sessions
**Mission Statement**: 
- We wanted to fill the desire for simplicity and security in users who have grown weary of convoluted modern communication software by providing a fast, simple, and secure solution. 
**Security Features**:
- End-to-end encrypted chats 
- Timed deletion of chats
**Orginization**: This project follows the [standard Laravel dependency structure](https://laravel.com/docs/5.7/structure). 

## Requirements (macOS)
1. homebrew `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
2. composer `brew install composer`
3. yarn `brew install yarn`
4. redis `brew install redis` and `brew services start redis` to start the service
5. php `brew install php` and `brew services start php` to start the service
6. mySQL `brew install mysql` and `brew services start mysql` to start the service

## Setup Guide
1. Ensure that MySQL, homebrew, redis, and php are running by using `brew services list`
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

## Development Stack (Architecture)
- Nginx web server (deployment)
- Laravel PHP Framework (back end) 
- MySQL database 
- Vue.js (front end)
- Redis server (queuing notifications)
- Socket.io (web sockets)

## Automated Test Cases
The tool used to perform automated testing is [PHPUnit](https://phpunit.de/), and the tests are written with the Laravel framework. The syntax for writing these tests are described [here](https://laravel.com/docs/5.7/testing).

For our project, rather than writing tests for the frontend (which would have been quite cumbersome), we wrote tests for our API endpoints that simulate the users doing actions on the front end.

In order to run these tests, you must first migrate and seed the database, which provides the filler data that the unit tests use. Then run the unit tests from the root of server directory using the following commands:

```bash
php artisan migrate:refresh --seed 
./vendor/bin/phpunit
```

These unit tests will test the following features of our application:
1. Sending a chat request
2. Sending a chat request while not logged in (the application should deny this behavior)
3. Accepting an incoming chat request
4. Rejecting an incoming chat request
5. Getting a list of chats while not logged in (the application should deny this behavior)
6. Sending a message
7. Sending a message while not logged in (the application should deny this behavior)
8. Getting a list of messages for a particular chat
9. Getting a list of messages for a particular chat while not logged in (the application should deny this behavior)

The source code for these tests can be found at: [https://github.com/lukemcd1994/bChat/blob/master/tests/Unit/ChatTest.php](https://github.com/lukemcd1994/bChat/blob/master/tests/Unit/ChatTest.php)

## Encryption
- If the server is compromised, the messages are undecipherable
- Users exchange a shared secret using ECDH, converted into an AES-256 key using HKDF
- Encryption keys stored on the client

## License
This project follows the standard MIT license.
