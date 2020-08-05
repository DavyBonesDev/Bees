<?php

namespace bees;

require_once "classes/dbh.class.php";

class Bees extends \Dbh
{

    public $health;
    public $status;
    public $role;
    static $totalBees = 0;
    static $resetBees = false;
    public $beeId;

    protected function __construct(string $role)
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
        // if($dbh == false)
        // {
        //     $this->connect()->query("INSERT INTO bees SET BeeRole='$this->role', BeeHealth=100, BeeStatus='$this->status'");
        //     $dbh = $conn->query("SELECT * FROM bees WHERE BeeID=$this->beeId");
        // }
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
        $this->connect()->query("INSERT INTO bees SET BeeRole='$this->role', BeeHealth=100, BeeStatus='$this->status'");
    }


    public function damage()
    {
        // if ($damage < 1 || $damage > 80) {
        //     throw new \Exception("Damage must be between 1 and 80");
        // }
        if($this->status == "Dead") {
            return $this;
        }

        $damage = rand(1, 80);
        $this->health = $this->health - $damage;        
        if($this->health < 0) {
            $this->health = 0;
        }
        $this->connect()->query("UPDATE bees SET BeeHealth='$this->health' WHERE BeeID='$this->beeId'");
        $this->setStatus();

        return $this;
    }
}
