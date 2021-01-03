<?php 
include('config.php');

if (isset($_GET['pass'])) 
{
	$pass = $_GET['pass'];
	$sql = "DELETE FROM car WHERE `car_id`='$pass'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "car.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "car.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
}

?>