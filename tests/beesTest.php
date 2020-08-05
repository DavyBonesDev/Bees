<?php
require "classes/bees/bees.class.php";
require "./vendor/autoload.php";
require_once "classes/bees/queen.class.php";
require_once "classes/bees/drone.class.php";
require_once "classes/bees/worker.class.php";
use bees\Bees;
use bees\Queen;
use bees\Drone;
use bees\Worker;
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
    public function damageLowersHp()
    {
        $queen = new Queen();
        $drone = new Drone();
        $worker = new Worker();

        $this->assertLessThan($queen->health, $queen->damage()->health);
        $this->assertLessThan($drone->health, $drone->damage()->health);
        $this->assertLessThan($worker->health, $worker->damage()->health);
    }

    // /**
    //  * @test
    //  */
    // public function createBeesReturnsArrayOfBeeObjects()
    // {
    //     $this->assertContainsOnlyInstancesOf(Bees::class, Bees::createBees(10, 1, 20));               
       
    // }    



    // /**
    //  * @test
    //  */
    // public function createBeesThrowsExceptionOnInvalidParameterType()
    // {
    //     $this->expectException(TypeError::class);
    //     Bees::createBees(1, "test", 0);
    // }

    // /**
    //  * @test
    //  */
    // public function createBeesThrowsExceptionOnInvalidParameterRange()
    // {
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage("createBees parameters must be between an integer 0 and 30");
    //     Bees::createBees(-10, 3, 4);
    // }
}