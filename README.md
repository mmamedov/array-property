[![Build Status](https://travis-ci.org/mmamedov/array-property.svg?branch=master)](https://travis-ci.org/mmamedov/array-property) [![Latest Stable Version](http://img.shields.io/packagist/v/mmamedov/array-property.svg)](https://packagist.org/packages/mmamedov/array-property) [![License](https://img.shields.io/packagist/l/mmamedov/array-property.svg)](https://packagist.org/packages/mmamedov/array-property) 


ArrayProperty
-------------
Syntax sugar for working with arrays in PHP. Read and write to arrays in an object-oriented style. Keys are treated as properties.

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
echo $a->app->log_dir;      //outputs /log/path
echo $a->app->deep->inner;  //outputs 'some value'

//convert to array
$deep = $a->app->deep->toArray();
print_r($deep);             //outputs deep as array;

//check if value exists:
$a->app->exist('log_dir')   //returns true
```

Load new array and acces its values inline:
```php
$prop = new ArrayProperty(array());
$new = array(1 => 'apple', 2 => 'orange', 3 => 'olive', 4 => 'grapes', 'multi'=>array('key'=>'value'));
echo $prop->loadArray($new)->{1}; //outputs "apple"
echo $prop->multi->key;           //outputs "value"
```

Now let's add new element to the `$prop` ArrayProperty object we created above:
```php
$prop->myNewNode = "myValue";   //you can assign arrays as well.
echo $prop->myNewNode;          //outputs 'myValue';
//overwrite existing elements
$prop->{1} = "banana"; 
echo $prop->{1};                //now outputs "banana" instead of "apple"
```

For more examples see code inside [ArrayProperty examples](examples/) directory.


Enjoy! 