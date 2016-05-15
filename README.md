[![Build Status](https://travis-ci.org/mmamedov/array-property.svg?branch=master)](https://travis-ci.org/mmamedov/array-property) [![Latest Stable Version](http://img.shields.io/packagist/v/mmamedov/array-property.svg)](https://packagist.org/packages/mmamedov/array-property) [![License](https://img.shields.io/packagist/l/mmamedov/array-property.svg)](https://packagist.org/packages/mmamedov/array-property) 


ArrayProperty
-------------
Syntax sugar for working with arrays in PHP. Makes it easier to access array elements. Keys are treated as properties.

ArrayProperty can be used on any PHP array variable.

Install using composer (recommended):
```
composer require mmamedov/array-property
```

Usage
-----
Consider the following sample PHP array:

```php
$sample =
    array(
        'app' => array(
            'log_dir' => '/log/path',
            'debug' => false,
            'log' => true,
            'version' => '2.3',
            'deep' => array(
                'inner' => 'some value',
                'level' => '2'
            )
        ),
        'my node' => 'some value'
    );
```

This is how easy to work with it using ArrayProperty:
```php
$a = new ArrayProperty($sample);
echo $a->app->log_dir; // prints /log/path
echo $a->app->deep->inner; //prints 'some value'

//convert to array
$deep = $a->app->deep->toArray();
print_r($deep); //outputs deep as array;

//check if value exists:
$a->app->exist('log_dir') //returns true
```

For more examples see code inside [ArrayProperty examples](examples/) directory.


Enjoy! 