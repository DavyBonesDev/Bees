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
        $bee = new Queen();

        $expected = 'Hello World';

        $this->assertEquals($expected, $bee->unitTest());
    }

    /**
     * @test
     */
    public function resetBeeGives100Health()
    {
        $queen = new Queen();
        $drone = new Drone();
        $worker = new Worker();

        $this->assertEquals(100, $queen->resetBee()->health);
        $this->assertEquals(100, $drone->resetBee()->health);
        $this->assertEquals(100, $worker->resetBee()->health);
    }

    /**
     * @test
     * @depends resetBeeGives100Health
     */
    public function damageLowersHp()
    {
        $queen = new Queen();
        $drone = new Drone();
        $worker = new Worker();

        $this->assertLessThan($queen->resetBee()->health, $queen->damage()->health);
        $this->assertLessThan($drone->resetBee()->health, $drone->damage()->health);
        $this->assertLessThan($worker->resetBee()->health, $worker->damage()->health);
    }

    /**
     * @test
     */
    public function damageDoesNotLowerHpIfBelowThreshold()
    {
        $queen = new Queen();
        $drone = new Drone();
        $worker = new Worker();

        $queen->health = 19;
        $drone->health = 49;
        $worker->health = 69;

        $this->assertEquals(19, $queen->damage()->health);
        $this->assertEquals(49, $drone->damage()->health);
        $this->assertEquals(69, $worker->damage()->health);

        $queen->health = 20;
        $drone->health = 50;
        $worker->health = 70;

        $this->assertLessThan(20, $queen->damage()->health);
        $this->assertLessThan(50, $drone->damage()->health);
        $this->assertLessThan(70, $worker->damage()->health);
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