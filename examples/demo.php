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
require __DIR__.'/../vendor/autoload.php';

use ArrayProperty\ArrayProperty;


//sample array data
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
        'database' =>
            array(
                'host' => 'localhost',
                'user' => 'test',
                'password' => 'testPwd=!',
                'name' => 'localdbname'
            )
    );

echo '<h3>print_r $sample array:</h3><pre>';
print_r($sample);
echo '</pre>';

/**
 * Construct ArrayProperty
 */
$a = new ArrayProperty($sample);

/**
 * Access any value, 'leaf'
 */
echo '<h3>Accessing values:</h3>';
echo '$a->app->log_dir: '. $a->app->log_dir ."<br/>"."\n";
echo '$a->app->deep->inner.: '.$a->app->deep->inner."<br/>"."\n";
echo '$a->database->name: '. $a->database->name."<br/>"."\n";
echo 'var_dump($a->app->log): <br/>';
var_dump($a->app->log);

/**
 * Check if leaf/node exists
 */
echo '<h3>Check if leaf/node exists:</h3>';
echo '$a->database->exist(\'host\'): '."<br/>"."\n";
var_dump($a->database->exist('host'));

/**
 * Convert nodes to arrays, has more 'leaves'
 */
echo '<h3>Convert using ->toArray() :</h3>';
$array_node = $a->database->toArray();
var_dump($array_node);

$deep = $a->app->deep->toArray();
var_dump($deep);

/**
 * Get internal PHP's ArrayObject element
 */
echo '<h3>Get internal PHP\'s ArrayObject element</h3>';
echo 'count: '. $a->getArrayObject()->count(); //count of values