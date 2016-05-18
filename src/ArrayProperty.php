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
class ArrayProperty
{
    /** @var \ArrayObject */
    private $array_ob;

    /**
     * @var int
     */
    private $mode;

    /**
     *  __get returns ArrayProperty object
     */
    const OBJECT_MODE = 100;

    /**
     * __get returns ArrayProperty object or value
     */
    const MIXED_MODE = 200;

    /**
     * Pass array as a parameter to constructor
     *
     * ArrayProperty constructor.
     * @param array $array to be converted
     * @param int $mode Defaults to MIXED_MODE
     */
    public function __construct(array $array, $mode = null)
    {
        $this->array_ob = new \ArrayObject($array);

        if (is_null($mode)) {
            $this->mode = $this::MIXED_MODE;
        } else {
            $this->mode = $mode;
        }
    }

    /**
     * Get array values (or indices).
     *
     * In OBJECT_MODE always returns ArrayProperty object
     * In MIXED_MODE returns the known value or ArrayProperty if not a 'leaf' (array value) is accessed.
     *
     * @param $name string Parameter to get extracted
     * @return ArrayProperty|mixed terminating node value, or last array
     * @throws \Exception when param not found
     */
    public function __get($name)
    {
        if (!$this->array_ob->offsetExists($name)) {
            throw new \Exception('ArrayProperty: param not found: ' . $name);
        }

        if ($this->mode == $this::OBJECT_MODE) {
            //constructor expects array
            $array_val = $this->array_ob->offsetGet($name);
            if (!is_array($array_val)) {
                $array_val = array($array_val);
            }
            return new ArrayProperty($array_val, $this->mode);
        } elseif ($this->mode == $this::MIXED_MODE) {
            if (is_array($this->array_ob->offsetGet($name))) {
                //is next array available, return ArrayProperty
                return new ArrayProperty($this->array_ob->offsetGet($name), $this->mode);
            } else {
                //not array, return value
                return $this->array_ob->offsetGet($name);
            }
        }

        //never reached, but to supress warning
        return null;
    }

    /**
     * First level set
     *
     * Example: $array_property->newKey = 'newValue';
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set($name, $value)
    {
        $this->array_ob->offsetSet($name, $value);

        return $this;
    }

    /**
     * Set mode (use class constants)
     *
     * @param $mode
     */
    public function setMode($mode)
    {
        if (!empty($mode)) {
            $this->mode = $mode;
        }
    }

    /**
     * Get mode
     *
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * See if main config item exists
     * @param $name string config item to check
     * @return bool true if exists, false if not
     */
    public function exist($name)
    {
        if ($this->array_ob->offsetExists($name)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Useful to call on a value that is known to be an array of other values
     *
     * @return array nodes value as array
     */
    public function toArray()
    {
        return $this->array_ob->getArrayCopy();
    }

    /**
     * Get internal $array_ob for further manipulation
     *
     * @return \ArrayObject
     */
    public function getArrayObject()
    {
        return $this->array_ob;
    }

    /**
     * Load a new array into ArrayProperty, and returns itself
     *
     * @param array $array
     * @return ArrayProperty
     */
    public function loadArray(array $array)
    {
        $this->array_ob = new \ArrayObject($array);

        return $this;
    }
}
