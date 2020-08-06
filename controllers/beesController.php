<?php

namespace Bees;

require "classes\bees\bees.class.php";
require_once "classes/bees/queen.class.php";
require_once "classes/bees/drone.class.php";
require_once "classes/bees/worker.class.php";
// use bees\Bees;


if(isset($_POST["resetBees"]) && $_POST["resetBees"] == 1) {  
  Bees::$resetBees = true;
}

if(isset($_POST["damage"])){    
  $damage = is_numeric($_POST["damage"]) ? intval($_POST["damage"]) : $_POST["damage"];
}

unset($_POST);

function createBees(int $queens, int $drones, int $workers)
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
            $bees[$i] = new Queen();
            continue;
        }
        if ($i < $queens + $drones + 1) {
            $bees[$i] = new Drone();
            continue;
        }
        if ($i < $queens + $drones + $workers + 1) {
            $bees[$i] = new Worker();
        }
    }
    return $bees;
}


$bees = createBees(10, 10, 10);
// echo "Total Bees: " . Bees::$totalBees;
foreach($bees as $bee) {
    print_r(get_object_vars($bee));
}

if(isset($damage))
{    
  if(is_int($damage)){
    $bees[$damage]->damage();
  } else if($damage == "all") {
    foreach($bees as $bee) 
    {
      $bee->damage();
    }
  }
}

?>