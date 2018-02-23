## ODBC integration for Laravel Framework
This integration allows the use of <b>odbc_*</b> php function with Laravel framework instead of PDO.<br>
It emulates PDO class used by Laravel.

### # How to install
> `composer require abram/laravel-odbc` To add source in your project

### # Usage Instructions
It's very simple to configure:

**1) Add database to database.php file**
```PHP
'odbc-connection-name' => [
    'driver' => 'odbc',
    'dsn' => 'OdbcConnectionName',
    'database' => 'DatabaseName',
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

### # Eloquen ORM
You can use Laravel, Eloquent ORM and other Illuminate's components as usual.
```PHP
# Facade
$books = DB::connection('odbc-connection-name')->table('books')->where('Author', 'Abram Andrea')->get();

# ORM
$books = Book::where('Author', 'Abram Andrea')->get();
```

### # Custom getLastInsertId() function
If you want to provide a custom <b>getLastInsertId()</b> function, you can extends *ODBCProcessor* class and override function.<br>
```PHP
class CustomProcessor extends ODBCProcessor
{
    /**
     * @param Builder $query
     * @param null $sequence
     * @return mixed
     */
    public function getLastInsertId(Builder $query, $sequence = null)
    {
        return $query->getConnection()->table($query->from)->latest('id')->first()->getAttribute($sequence);
    }
}
```

### # Custom Processor / QueryGrammar / SchemaGrammar
To use another class instead default one you can update your connection in:
```PHP
'odbc-connection-name' => [
    'driver' => 'odbc',
    'dsn' => 'OdbcConnectionName',
    'database' => 'DatabaseName',
    'host' => '127.0.0.1',
    'username' => 'username',
    'password' => 'password',
    'options' => [
        'processor' => Illuminate\Database\Query\Processors\Processor::class,   //default
        'grammar' => [
            'query' => Illuminate\Database\Query\Grammars\Grammar::class,       //default
            'schema' => Illuminate\Database\Schema\Grammars\Grammar::class      //default
        ]
    ]
]
```
