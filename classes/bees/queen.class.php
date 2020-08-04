<?php

namespace bees;

require_once "classes/bees/bees.class.php";
require_once "classes/bees/iBees.class.php";

class Queen extends Bees implements iBees
{
    
    function __construct()
    {
        parent::__construct("Queen");
    }

    public function setStatus() 
    {
        if($this->health < 20) {
            $this->status = "Dead";
            return;
        }
        $this->status = "Alive";
    }
}