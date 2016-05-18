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
                'database' => array(
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

    public function testConstructor()
    {
        $prop = $this->ap;

        $this->assertAttributeEquals($prop::MIXED_MODE, 'mode', $this->ap);
        $this->assertTrue($prop->getArrayObject() instanceof \ArrayObject);
    }

    public function testSetMode()
    {
        $prop = $this->ap;

        $prop->setMode($prop::OBJECT_MODE);
        $this->assertAttributeEquals($prop::OBJECT_MODE, 'mode', $this->ap);

        $prop->setMode($prop::MIXED_MODE);
        $this->assertAttributeEquals($prop::MIXED_MODE, 'mode', $this->ap);
    }

    /**
     * @depends testSetMode
     */
    public function testGetMode()
    {
        $prop = $this->ap;

        $prop->setMode(ArrayProperty::MIXED_MODE);
        $this->assertEquals(ArrayProperty::MIXED_MODE, $prop->getMode());

        $prop->setMode(ArrayProperty::OBJECT_MODE);
        $this->assertEquals(ArrayProperty::OBJECT_MODE, $prop->getMode());

    }

    public function testGet()
    {
        $prop = $this->ap;

        $this->assertNotEmpty($prop->some);
        $this->assertFalse($prop->app->debug);
        $this->assertTrue($prop->app->log);

        //change mode
        $prop->setMode(ArrayProperty::OBJECT_MODE);
        $this->assertTrue($prop->some instanceof ArrayProperty);
        $this->assertTrue($prop->database->host instanceof ArrayProperty);
        $this->assertTrue($prop->some instanceof ArrayProperty);
        $this->assertTrue($prop->{12} instanceof ArrayProperty);
        $this->assertTrue($prop->array instanceof ArrayProperty);
        $this->assertTrue($prop->app->deep->inner instanceof ArrayProperty);
        $this->assertNotEquals($prop->some, 'value');

        //change mode
        $prop->setMode(ArrayProperty::MIXED_MODE);
        $this->assertEquals($prop->some, 'value');
        $this->assertEquals($prop->database->host, 'localhost');
        $this->assertEquals($prop->some, 'value');
        $this->assertEquals($prop->{12}, 2016);
        $this->assertInternalType('integer', $prop->{12});
        $this->assertNotInternalType('string', $prop->{12});
        $this->assertTrue($prop->array instanceof ArrayProperty);
        $this->assertEquals($prop->app->deep->inner, 'some value');
    }

    public function testSet()
    {
        $prop = $this->ap;

        $prop->newvalue = "test";
        $this->assertEquals($prop->newvalue, 'test');

        $prop->newvalue = 987;
        $this->assertEquals($prop->newvalue, 987);
        $this->assertInternalType('integer', $prop->newvalue);

        $prop->newvalue = false;
        $this->assertEquals(false, $prop->newvalue);
        $this->assertInternalType('boolean', $prop->newvalue);


        $prop->newNode = array('my' => array('inner' => 'value', 'some' => 'other'));
        $this->assertNotEmpty($prop->newNode);
        $this->assertEquals('other', $prop->newNode->my->some);
        $this->assertTrue($prop->newNode->my instanceof ArrayProperty);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetException()
    {
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

    public function testLoadArray()
    {
        $this->assertAttributeNotEmpty('array_ob', $this->ap);

        $this->ap->loadArray(array());
        $this->assertAttributeEmpty('array_ob', $this->ap);

        $this->ap->loadArray(array('some', 'value', 'third'));
        $this->assertEquals(3, count($this->ap->toArray()));
    }
}
