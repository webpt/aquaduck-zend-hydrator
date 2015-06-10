<?php

namespace Webpt\Aquaduck\Zend\HydratorTest;

use Webpt\Aquaduck\Zend\Hydrator\ExtractionMiddleware;

class ExtractionMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    protected $middleware;

    protected function setUp()
    {
        $this->middleware = new ExtractionMiddleware();
    }

    public function testCanExtractValues()
    {
        $middleware = $this->middleware;
        $result = $middleware(new \ArrayObject(array(1, 'foo')));

        $this->assertInternalType('array', $result);
        $this->assertCount(2, $result);
        $this->assertContains(1, $result);
        $this->assertContains('foo', $result);
    }

    /**
     * @expectedException \Webpt\Aquaduck\Exception\InvalidArgumentException
     */
    public function testThrowsExceptionOnNonObject()
    {
        $middleware = $this->middleware;
        $middleware('NOT AN OBJECT');
    }
}
