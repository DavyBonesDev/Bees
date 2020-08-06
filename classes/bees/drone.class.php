<?php

namespace bees;

require_once "classes/bees/bees.class.php";
require_once "classes/bees/iBees.class.php";

class Drone extends Bees
{

    function __construct()
    {
        parent::__construct("Drone");
    }

    public function setStatus() 
    {
        if($this->health < 50) {
            $this->status = "Dead";
            return $this;
        }
        $this->status = "Alive";
        return $this;
    }
}