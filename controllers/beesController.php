<?php
require "classes\bees\bees.class.php";
use bees\Bees;

if(isset($_POST["resetBees"]) && $_POST["resetBees"] == 1) {  
  Bees::$resetBees = true;
}

if(isset($_POST["damage"])){    
  $damage = is_numeric($_POST["damage"]) ? intval($_POST["damage"]) : $_POST["damage"];
}

unset($_POST);

$bees = Bees::createBees(10, 10, 10);
// echo "Total Bees: " . Bees::$totalBees;
foreach($bees as $bee) {
    // print_r(get_object_vars($bee));
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