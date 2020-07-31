<?php

require "controllers\beesController.php";

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->

</head>
<style>

  .bees{
    display: table; 
    width:100%
  }

  .bee{
    width: calc(25% - 26px);
    border:solid;
    display: inline-block;    
    margin: 10px 20px 10px 0px;
  }

  .bees > .bee:nth-child(4n)
  {
    margin: 10px 0px 10px 20px;
  }
  
  .beeStats{
    display: inline-flex;
    width: 100%;
    margin-top: -9px;
  }

  .beeStat{
    width: 50%;
  }

  button{
    text-align: center;
    width: 100%;
    padding: 15px;
    font-weight: bold;
  }

  h3{
    text-align: center;
  }

  .queen h1{
    background-color: gold;
  }
  .drone h1{
    background-color: mediumaquamarine;
  }
  .worker h1{
    background-color: cornflowerblue;
  }

</style>

<body>
<form method="POST">
  <button name="resetBees" value="1">Reset all Bees</button>
  <button name="damage" value="all">Damage all Bees</button>
  <div class="bees">
  <?php
  foreach($bees as $bee)
  {?>
    <div class="bee <?=lcfirst($bee->role)?>">
      <h1 style="text-align:center"><?=$bee->role?> Bee</h1>
      <hr>
      <div class="beeStats">
        <div class="beeStat" style="border-right: solid 1px grey;">
          <h3>Status:</h3>
          <h3><?=$bee->status?></h3>
        </div>          
        <div class="beeStat">
          <h3>Health:</h3>
          <h3><?=$bee->health?></h3>
        </div>
      </div>
      <button name="damage" value="<?=$bee->beeId?>">Damage Bee</button>
    </div>
  <?php } ?>
</form>  
</body>
</html>