<?php

use bees\Bees;



class beesTest extends PHPunit\Framework\TestCase
{
    public function unitTestReturnsHelloWorld()
    {
        $bee = new Bees("Queen");

        $expected = 'Hello World';

        $this->assertEquals($expected, $bee->unitTest());
    }
}