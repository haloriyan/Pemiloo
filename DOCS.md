# Documentation

### Table of Contents
1. [Router](#router)
2. [view()](#view)
3. [redirect()](#redirect)
4. [middleware()](#middleware)
5. [Query Builder](#querybuilder)
6. [File Handler](#filehandler)
7. [cURL](#curl)

### Router <a name="router"></a>
(located in routes.php)
```
// example
$routes [
    'welcome/{name}' => 'GET:UserController@welcomePage',
];
```

'welcome' (index of array) is path of your route. And the value we got 3 sections, `GET` is HTTP Method you want to use, `UserController` is controller's file will handle the request, and `welcomePage` is method inside UserController that handle request. UserController file located in `/app/Controllers/` and the file named `UserController.php`. Then, inside `welcomePage()` method, you can return view with view() helper

### view($file_location `string`, $paramsToPass `array`) <a name="view"></a>

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

### redirect($path `string`, $params `array`) <a name="redirect"></a>

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

### middleware($name `string`, $exception `array`) <a name="middleware"></a>

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

### Database Query Builder <a name="querybuilder"></a>

If you have used builder in laravel, obviously you will familiar with this.

```php
// You have to add this
use DB as DB;

class VoterController {
    public function info($id) {
        $data = DB::table('users')
                    ->where([
                        ['id', '=', $id]
                    ])->get();

        return $data;    
    }
}
```

### Simple file handler <a name="filehandler"></a>

```php
class VoterControler {
    public function store() {
        $photo = $_FILES['photo'];

        $upload = Storage::disk('cover')->store('/', $photo);
    }
}
```
