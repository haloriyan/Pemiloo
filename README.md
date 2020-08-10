# Simple Polling App

This web-app was made just for fun. I want to try back to native-way again like the old time. Although I said "with PHP Native", this wasn't so native like 'newbie' programmer do. I wrote this code in better way, and made few helper that make the code looks more beauty as laravel code. To see how to use the helper just check it on DOCS.md

## How to Install

### 0. Clone
First, clone this repo to your local/live machine, then move into web-server directory. Rename `public/` directory to be `html/` or `public_html` depends what your machine use. But if you using apache2 as I used, move into `/var/www/` and rename `public/` to `html/`.

### 1. Create Database
Login to your MySQL via CLI or PHPMyAdmin, and create new database

`CREATE DATABASE polling;`


### 2. Setup Config
Anything what you need to config was located in .env file. All configs you have to change are APP_URL, database connection, and mailing configuration.

### 3. Migrate Database
I had setting up tables structure in `migration.json` file. You just have to migrate it by running `migrate.php` via php cli.


```
your-machine:/var/www $ ~ php migrate.php
```

### 4. Add new Admin
Insert new data for admin in `admins` table manually. Special for `password`'s column, you have to encrypt it with MD5 due to login process is using MD5 too.

## Support

If you meet any issue of this application, you can contact me via [Telegram @haloriyan](https://t.me/haloriyan) or [Instagram @haloriyan](https://www.instagram.com/haloriyan). I will help you anything you ask about this.