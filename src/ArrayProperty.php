<?php
/**
 * This file is part of the ArrayProperty package.
 *
 * @author Muhammed Mamedov <mm@turkmenweb.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ArrayProperty;

/**
 * Convert PHP array to an ArrayProperty object for a simple and intuitive array access.
 *
 * Class ArrayProperty
 * @package ArrayProperty
 */
class ArrayProperty{

    private $array_ob;

    /**
     * Pass array as a parameter to constructor
     *
     * ArrayProperty constructor.
     * @param array $array to be converted
     */
    public function __construct(array $array){
        $this->array_ob = new \ArrayObject($array);
    }

    /**
     * Recursive calls to parameters
     *
     * @param $name string Parameter to get extracted
     * @return ArrayProperty|string terminating node value, or last array
     * @throws \Exception when param not found
     */
    public function __get($name)
    {
        if($this->array_ob->offsetExists($name)) {

            if (is_array($this->array_ob->offsetGet($name))) {
                //is next array available, return ArrayProperty
                return new ArrayProperty($this->array_ob->offsetGet($name));
            } else {
                //not array, text node
                return strval($this->array_ob->offsetGet($name));
            }
        }
        else{
            throw new \Exception('ArrayProperty: param not found: '.$name);
        }
    }

    /**
     * See if main config item exists
     * @param $name string config item to check
     * @return bool true if exists, false if not
     */
    public function exist($name){
        if($this->array_ob->offsetExists($name)) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Usefull to call on a value that is known to be an array of other values
     *
     * @return array nodes value as array
     */
    public function toArray(){
        return $this->array_ob->getArrayCopy();
    }

    /**
     * Get internal $array_ob for further manipulation
     *
     * @return \ArrayObject
     */
    public function getArrayObject(){
        return $this->array_ob;
    }

}
