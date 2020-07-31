<?php
require "classes/bees/bees.class.php";
require "./vendor/autoload.php";
use bees\Bees;

use PHPUnit\Framework\TestCase;

class BeesTest extends TestCase
{
    /**
     * @test
     */
    public function unitTestReturnsHelloWorld()
    {
        $bee = new Bees("Queen");

        $expected = 'Hello World';

        $this->assertEquals($expected, $bee->unitTest());
    }

    /**
     * @test
     */
    public function createBeesReturnsArrayOfBeeObjects()
    {
        $this->assertContainsOnlyInstancesOf(Bees::class, Bees::createBees(10, 1, 20));               
       
    }    

    /**
     * @test
     */
    public function createBeesThrowsExceptionOnInvalidParameterType()
    {
        $this->expectException(TypeError::class);
        Bees::createBees(1, "test", 0);
    }

    /**
     * @test
     */
    public function createBeesThrowsExceptionOnInvalidParameterRange()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("createBees parameters must be between an integer 0 and 30");
        Bees::createBees(-10, 3, 4);
    }
}