# Simple Polling App

This web-app was made just for fun. I want to try back to native-way again like the old time. Although I said "with PHP Native", this wasn't so native like 'newbie' programmer do. I wrote this code in better way, and made few helper that make the code looks more beauty as laravel code.

In this repo's, there are few helper, either :

### Router
(located in routes.php)
```
// example
$routes [
    'welcome/{name}' => 'GET:UserController@welcomePage',
];
```

'welcome' (index of array) is path of your route. And the value we got 3 sections, `GET` is HTTP Method you want to use, `UserController` is controller's file will handle the request, and `welcomePage` is method inside UserController that handle request. UserController file located in `/app/Controllers/` and the file named `UserController.php`. Then, inside `welcomePage()` method, you can return view with view() helper

### view($file_location `string`, $paramsToPass `array`)

```
// example
public function welcomePage($name) {
    return view('anyfolder.welcome', [
        'name' => $name
    ]);
}
```

That code will receive parameter(s) from route path ordered by position (just like laravel). Then it returning a view, which located in `/views/anyfolder/welcome.php`. And the second parameter is parameter will passed into view file. So, the view file can written like this

```
Hello, <?= $name ?>
```

### redirect($path `string`, $params `array`)

```
// example
public function loginAction() {
    // login process
    if (!$userLoggedIn) {
        redirect('login', [
            'errorMessage' => "Sorry, your email and/or password are wrong"
        ]);
    }
}
```

$path was from router path. And you have to write it fillfully. So if you have parameter in route path like `polling/{id}/edit`, you have to write id in first parameter as `polling/23/edit`

### middleware($name `string`, $exception `array`)

```
// Middleware Example
class Admin {
    public function handle() {
        $data = Session::get('admin);
        if ($data == "" or count($data) == 0) {
            redirect('login', ["errorMessage" => "You have to login first"]);
        }
    }
}

// Example in controller
use Controller as App;

class AdminController {
    public function __construct() {
        App::middleware('Admin', ['loginPage']);
    }
    public function loginPage() {
        return view('login);
    }
    public function dashboard() {
        // dashboard logic
    }
}
```

- database query builder
- simple file handler
- cURL readable function

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