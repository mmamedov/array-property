<?php

/**
 * This file is part of the ArrayProperty package.
 *
 * @author Muhammed Mamedov <mm@turkmenweb.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ArrayProperty\Tests;

use ArrayProperty\ArrayProperty;

class ArrayPropertyTest extends \PHPUnit_Framework_TestCase
{
    private $sample;

    /** @var  ArrayProperty */
    private $ap;

    public function setUp()
    {
        $this->sample =
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
                    ),
                'some' => 'value',
                'empty',
                12 => 2016,
                'array' => array(0 => 'another array')
            );

        $this->ap = new ArrayProperty($this->sample);
    }

    public function tearDown()
    {
        unset($this->sample);
        unset($this->ap);
    }

    public function testConstructAndGetArrayObject()
    {
        $array = $this->ap;

        $this->assertTrue($array->getArrayObject() instanceof \ArrayObject);
        $this->assertNotEmpty($array->some);
        $this->assertFalse($array->app->debug);
        $this->assertTrue($array->app->log);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetException(){
       // $this->expectException(\Exception::class);
        $this->ap->nonexistant;
    }

    public function testToArray()
    {
        $tmp = $this->ap->toArray();
        $this->assertEquals(6, count($tmp));
    }

    public function testToArrayNode()
    {
        $sample_app = $this->ap->app->toArray();
        $tmp = array(
            'log_dir' => '/log/path',
            'debug' => false,
            'log' => true,
            'version' => '2.3',
            'deep' => array(
                'inner' => 'some value',
                'level' => '2'
            )
        );
        $this->assertEquals($tmp, $sample_app);

        $another = $this->ap->array->toArray();
        $this->assertEquals(array('0' => 'another array'), $another);
    }

    public function testExist()
    {
        $this->assertTrue($this->ap->exist('app'));
        $this->assertTrue($this->ap->exist(12));
        $this->assertTrue($this->ap->database->exist('host'));

        $this->assertFalse($this->ap->database->exist('sfsdfdsf'));
        $this->assertFalse($this->ap->exist('nonexsistant'));

    }

}