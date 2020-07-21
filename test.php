<?php
require "classes\bees\bees.class.php";
use bees\Bees;
$bees = Bees::createBees(10, 10, 10);
echo "Total Bees: " . Bees::$totalBees;
foreach($bees as $bee) {
    print_r(get_object_vars($bee));
}
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- <link rel="stylesheet" href="css/styles.css?v=1.0"> -->

</head>

<body>
  <script src="js/scripts.js"></script>
</body>
</html>