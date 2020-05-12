**Handle Laravel SQLite limitation**

works with Laravel 5.6, 5.7, 5.8, 6.x, 7.x

```shell
composer require psylogic/laravel-sqlite-handler
```

> Based on PR https://github.com/laravel/framework/pull/32737

Sometimes we are dealing with an existing projects and we decide to add Unit Testing,
the issue is when we have a hundreds of migrations some of them are dropping columns and adding new columns to an existing tables also dropping foreign keys it become hard to maintain since we always prefer to use SQLite on memory or local file
The solution that provided is adding more test inside the migrations files like: 
 
 
```php
if (\DB::getDriverName() != 'sqlite') {
  $table->string('column');
}else{
  $table->string('column')->nullable();
}
```

```php
if (\DB::getDriverName() != 'sqlite') {
   $table->dropColumn('column1');
   $table->dropColumn('column2');
}else{
   $table->dropColumn(['column1', 'column2']);
}
```
> Or without conditions you can update your code to ```$table->dropColumn(['column1', 'column2']);``` it is acceptable by default in Laravel for all drivers


```php
if (\DB::getDriverName() != 'sqlite') {
  $table->dropForeign('name');
}
```
Or Create **separate migrations** or modify all the affected migrations by refactoring code to suit SQLite limitations.

***Now you shouldn't be worry about adding condition in the migrations files or create separete migrations***

What Covered:

 - dropping columns in one single migration file
 - Add Nullable for new columns on existing table (Fix Cannot add a NOT NULL column with default value NULL)
 - dropping foreign keys


Still working on the other limitations
