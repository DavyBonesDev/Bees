<?php

namespace bees;

require "classes/dbh.class.php";

// interface iBees {
//     public function damage(int $damage);
//     public function setRole(string $beeRole);
// }

class Bees extends \Dbh
{

    public $health;
    public $status;
    public $role;
    static $totalBees = 0;
    static $resetBees = false;
    public $beeId;

    function __construct(string $role)
    {
        self::$totalBees++;
        $this->role = ucFirst($role);        
                
        self::$resetBees ? $this->resetBee() : $this->getBee();       
        $this->setStatus();
    }

    private function setStatus()
    {

        switch($this->role)
        {
            case "Queen":
                if($this->health < 20) {
                    $this->status = "Dead";
                    return;
                }
            break;
            case "Drone":
                if($this->health < 50) {
                    $this->status = "Dead";
                    return;
                }
            break;
            case "Worker":
                if($this->health < 70) {
                    $this->status = "Dead";
                    return;
                }
            break;
        }        
        $this->status = "Alive";        
    }

    public function unitTest()
    {
        return "Hello World";
    }

    private function getBee()
    {
        $this->beeId = self::$totalBees;

        $conn = $this->connect();
        
        $dbh = $conn->query("SELECT * FROM bees WHERE BeeID=$this->beeId");

        if($beeData = $dbh->fetch())
        {            
            $this->role = $beeData["BeeRole"];
            $this->health = intval($beeData["BeeHealth"]);
            $this->status = $beeData["BeeStatus"];            
            return true;
        }
        return false;
    }

    private function resetBee()
    {                
        if($this->getBee()) {            
            $this->health = 100;
            $this->connect()->query("UPDATE bees SET BeeRole='$this->role', BeeHealth=$this->health, BeeStatus='$this->status' WHERE BeeID='$this->beeId'");
            return;
        }
        $this->connect()->query("INSERT INTO bee SET BeeRole='$this->role', BeeHealth=100, BeeStatus='$this->status'");
    }

    private function updateBee()
    {
        $this->connect()->query("UPDATE bees SET BeeRole='$this->role', BeeHealth='$this->health', BeeStatus='$this->status' WHERE BeeID='$this->beeId'");
    }

    public function damage()
    {
        // if ($damage < 1 || $damage > 80) {
        //     throw new \Exception("Damage must be between 1 and 80");
        // }
        if($this->status == "Dead") {
            return;
        }

        $damage = rand(1, 80);
        $this->health = $this->health - $damage;        
        if($this->health < 0) {
            $this->health = 0;
        }
        $this->connect()->query("UPDATE bees SET BeeHealth='$this->health' WHERE BeeID='$this->beeId'");
        $this->setStatus();
    }

    static public function createBees(int $queens, int $drones, int $workers)
    {
        if ( ($queens < 0 || $queens > 30)
            || ( $drones < 0 || $drones > 30)
            || ( $workers < 0 || $workers > 30)
        ) {
            throw new \Exception("createBees parameters must be between an integer 0 and 30");
        }

        $total = $queens + $drones + $workers;
        for ($i = 1; $i < $total + 1; $i++) {

            //TODO put into ranges
            if ($i < $queens + 1) {
                $bees[$i] = new Bees("Queen");
                continue;
            }
            if ($i < $queens + $drones + 1) {
                $bees[$i] = new Bees("Drone");
                continue;
            }
            if ($i < $queens + $drones + $workers + 1) {
                $bees[$i] = new Bees("Worker");
            }
        }
        return $bees;
    }
}
