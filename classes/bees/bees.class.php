<?php

namespace bees;

require_once "classes/dbh.class.php";

abstract class Bees extends \Dbh
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
                
        if(self::$resetBees) {
            $this->resetBee();
        } elseif(!$this->getBee()) {
            $this->resetBee();
        }
        // $this->setStatus();
    }

    abstract protected function setStatus();

    // private function setStatus()
    // {

    //     switch($this->role)
    //     {
    //         case "Queen":
    //             if($this->health < 20) {
    //                 $this->status = "Dead";
    //                 return $this;
    //             }
    //         break;
    //         case "Drone":
    //             if($this->health < 50) {
    //                 $this->status = "Dead";
    //                 return $this;
    //             }
    //         break;
    //         case "Worker":
    //             if($this->health < 70) {
    //                 $this->status = "Dead";
    //                 return $this;
    //             }
    //         break;
    //     }        
    //     $this->status = "Alive";
    //     return $this;        
    // }

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

    public function resetBee()
    {                
        if($this->getBee()) {            
            $this->health = 100;
            $this->connect()->query("UPDATE bees SET BeeRole='$this->role', BeeHealth=$this->health, BeeStatus='Alive' WHERE BeeID='$this->beeId'");
            return $this->setStatus();
        }
        $this->health = 100;
        $this->status = 'Alive';
        $this->connect()->query("INSERT INTO bees SET BeeRole='$this->role', BeeHealth=$this->health, BeeStatus='$this->status'");
        return $this->setStatus();
    }


    public function damage()
    {
        $this->setStatus();
        
        if($this->status == "Dead") {
            
            return $this;
        }

        $damage = rand(1, 80);
        $this->health = $this->health - $damage;        
        if($this->health < 0) {
            $this->health = 0;
        }
       
        // throw new \exception($this->status);
        $this->setStatus();
        $this->connect()->query("UPDATE bees SET BeeHealth='$this->health', BeeStatus='$this->status' WHERE BeeID='$this->beeId'");

        return $this;
    }
}
