<?php

namespace bees;

require_once "classes/bees/bees.class.php";
require_once "classes/bees/iBees.class.php";

class Queen extends Bees
{
    
    function __construct()
    {
        parent::__construct("Queen");
    }

    public function setStatus() 
    {
        if($this->health < 20) {
            $this->status = "Dead";
            return $this;
        }
        $this->status = "Alive";
        return $this;
    }
}