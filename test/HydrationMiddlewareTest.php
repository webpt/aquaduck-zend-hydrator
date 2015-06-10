<?php

namespace Webpt\Aquaduck\Zend\HydratorTest;

use Webpt\Aquaduck\Zend\Hydrator\HydrationMiddleware;
use Webpt\Aquaduck\Zend\HydratorTest\TestAsset\ExtendedArrayObject;

class HydrationMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    protected $middleware;

    protected function setUp()
    {
        $this->middleware = new HydrationMiddleware();
    }

    public function testCanHydrateValues()
    {
        $middleware = $this->middleware;
        $result = $middleware(array(1, 'foo'));

        $this->assertInstanceOf('ArrayObject', $result);
        $this->assertContains(1, $result);
        $this->assertContains('foo', $result);
    }

    /**
     * @expectedException \Webpt\Aquaduck\Exception\InvalidArgumentException
     */
    public function testThrowsExceptionOnNonArray()
    {
        $middleware = $this->middleware;
        $middleware('NOT AN ARRAY');
    }

    public function testCanCreateObjectPrototypeFromString()
    {
        $middleware = new HydrationMiddleware(null, 'ArrayObject');
        $result = $middleware(array(1, 'foo'));

        $this->assertInstanceOf('ArrayObject', $result);
    }

    /**
     * @expectedException \Webpt\Aquaduck\Exception\InvalidArgumentException
     */
    public function testThrowsExceptionOnInvalidObjectPrototypeString()
    {
        new HydrationMiddleware(null, 'TOTallyInValidClassName');
    }

    /**
     * @expectedException \Webpt\Aquaduck\Exception\InvalidArgumentException
     */
    public function testThrowsExceptionOnInvalidObjectPrototype()
    {
        new HydrationMiddleware(null, array('An Array Is Not Valid'));
    }

    public function testCanAcceptObjectAsObjectPrototype()
    {
        $middleware = new HydrationMiddleware(null, new ExtendedArrayObject());
        $result = $middleware(array(1, 'foo'));

        $this->assertInstanceOf('Webpt\Aquaduck\Zend\HydratorTest\TestAsset\ExtendedArrayObject', $result);
    }
}
