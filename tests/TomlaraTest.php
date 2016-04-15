<?php

use Inaba\Tomlara;

class TomlaraTest extends PHPUnit_Framework_TestCase
{
    public function testParseFunc()
    {
        $obj = new Tomlara();
        $method = $this->getMethod($obj, 'parseFunc');

        $value = '%sprintf:hello %s,world%';
        $method->invokeArgs($obj, array(&$value));

        $this->assertEquals('hello world', $value);
    }

    private function getMethod($obj, $name)
    {
        $class = new ReflectionClass(get_class($obj));

        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}
