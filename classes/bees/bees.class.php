<?php

namespace bees;

require "/laragon/www/Bees/classes/dbh.class.php";

// interface iBees {
//     public function damage(int $damage);
//     public function setRole(string $beeRole);
// }

class Bees extends \Dbh
{

    public $health = 100;
    public $status;
    public $role;
    static $totalBees = 0;
    public $beeId;

    function __construct(string $role)
    {
        self::$totalBees++;
        $this->role = ucFirst($role);
        $this->status = "Alive";
        $this->setBee();
    }

    public function unitTest()
    {
        return "Hello World";
    }

    private function setBee()
    {
        $this->beeId = self::$totalBees;

        $beeCheckSql = "SELECT * FROM bees WHERE id='$this->beeId'";
        if ($this->connect()->query($beeCheckSql)->fetch()) {
            //update statement
            $this->updateBee();
            return;
        }
        //insert statement
        $this->connect()->query("INSERT INTO bees SET Role='$this->role', Health='$this->health', `Status`='$this->status'");
    }

    private function updateBee()
    {
        $this->connect()->query("UPDATE bees SET Role='$this->role', Health='$this->health', `Status`='$this->status' WHERE ID='$this->beeId'");
    }

    public function damage(int $damage = 0)
    {
        if ($damage < 0 || $damage > 100) {
            throw new \Exception("Damage must be between 0 and 100");
        }
    }

    static public function createBees(int $queens, int $drones, int $workers)
    {
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
