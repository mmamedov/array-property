<?php
/**
 * This file is part of the ArrayProperty package.
 *
 * @author Muhammed Mamedov <mm@turkmenweb.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//composer autoload
require __DIR__ . '/../vendor/autoload.php';

use ArrayProperty\ArrayProperty;

//create empty object
$array_property = new ArrayProperty(array());

//empty object verification
var_dump($array_property->toArray());

//not exists
if (!$array_property->exist('firstOne')) {
    echo 'firstOne value not exists<br>';
}

$array_property->firstOne = 'firstvalue';
$array_property->anotherValue = 'anotherOne';

//see new array
var_dump($array_property->toArray());

//access new array elements
echo $array_property->firstOne . '<br>';
echo $array_property->anotherValue . '<br>';

//add more values
$new_add = array(
    'person' => array(
        'name' => 'Muhammed',
        'lastname' => 'Mamedov'
    ),
    'stuff' => array(
        'read' => 'books',
        'hobby' => 'fish'
    )
);

//add above array
$array_property->third = $new_add;

//access new elements
echo $array_property->third->person->name . '<br>';

//check structure
var_dump($array_property->toArray());

//Change to Object Mode
$array_property->setMode(ArrayProperty::OBJECT_MODE);
//We are in Object mode, so vardump will return an ArrayProperty object
var_dump($array_property->third->person->lastname);

//change back to mixed mode
$array_property->setMode(ArrayProperty::MIXED_MODE);
//now string will be printed
var_dump($array_property->third->person->lastname);
