<?php

namespace bees;

require_once "classes/bees/bees.class.php";
require_once "classes/bees/iBees.class.php";

class Worker extends Bees implements iBees
{

    function __construct()
    {
        parent::__construct("Worker");
    }

    public function setStatus() 
    {
        if($this->health < 70) {
            $this->status = "Dead";
            return;
        }
        $this->status = "Alive";
    }
}