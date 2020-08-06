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
        } else {
            // if(!$this->getBee()) {
            //     $this->resetBee();
            //     echo($this->beeId);
            // }
            $this->getBee();
        }        
    }

    abstract protected function setStatus();

    private function getBee()
    {
        $this->beeId = self::$totalBees;

        $conn = $this->connect();
        
        $dbh = $conn->query("SELECT * FROM bees WHERE BeeSlot=$this->beeId");                        
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
            $this->connect()->query("UPDATE bees SET BeeRole='$this->role', BeeHealth=$this->health, BeeStatus='Alive' WHERE BeeSlot='$this->beeId'");
            return $this->setStatus();
        }
        $this->health = 100;
        $this->status = 'Alive';
        $this->connect()->query("INSERT INTO bees SET BeeRole='$this->role', BeeHealth=$this->health, BeeStatus='$this->status', BeeSlot='$this->beeId'");
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
               
        $this->setStatus();
        $this->connect()->query("UPDATE bees SET BeeHealth='$this->health', BeeStatus='$this->status' WHERE BeeSlot='$this->beeId'");

        return $this;
    }
}
