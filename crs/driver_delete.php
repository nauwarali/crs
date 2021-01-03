<?php 
include('config.php');

if (isset($_GET['pass'])) 
{
	$pass = $_GET['pass'];
	$sql = "DELETE FROM driver WHERE `driver_id`='$pass'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "driver.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "driver.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
}

?>