## ODBC integration for Laravel Framework
This integration allows use <b>odbc_*</b> php function with Laravel framework instead PDO.<br>
It emulates PDO class used by Laravel.

### How to install
> `composer require abram/laravel-odbc` To add source in your project

### Usage Instructions
It's very simple to configure:

**1) Add database to database.php file**
```PHP
'odbc-connection-name' => [
    'driver' => 'odbc',
    'dsn' => 'OdbcConnectionName',
    'host' => '127.0.0.1',
    'username' => 'username',
    'password' => 'password'
]
```

**2) Add service provider in app.php file**
```PHP
'providers' => [
  ...
  Abram\Odbc\ODBCServiceProvider::class
]
```

## Eloquen ORM
You can use Laravel, Eloquent ORM and other Illuminate's components as usual.
```PHP
$books = Book::where('Author', 'Abram Andrea')->get();
```
