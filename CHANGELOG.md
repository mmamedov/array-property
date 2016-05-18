ArrayProperty Changelog
=======================

### 1.1.1 (2016-05-18)

* ArrayProperty::MIXED_MODE and ArrayProperty::OBJECT_MODE added. Constructor defaults to MIXED_MODE 
* Dynamically change operation mode via setMode(). Magic __get() returns results depending on mode set.
* PSR-2 adopted (phpcs, php-cs-fixer validated)
* loadArray() added. Reload any array into the object after initialization.
* Writing values is enabled! For now, first dimension only: $array_prop->newNodeName = "newValue";
* Writing overwrites any existing values. Multidimensional write is not supported, like in $arr_prop->firstIndex->second = "values"  
* loadArray and magic __set support auto chaining ($this is returned internally) 
* Tests updated. Now being tested for PHP versions 5.5, 5.6, 7.0.

### 1.1.0 (2016-05-15)

* String casting using strval() removed from array elements.
* Travis support enabled

### 1.0.1 (2016-05-14)

* Tests added
* Overall improvements

### 1.0.0 (2016-05-14)

* Initial Release
* ArrayProperty supports array access in an OOP way (read access only)
* Multidimensional arrays are supported
* Access using the following syntax: $var->key->anotherkey 
