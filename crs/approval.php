<?php 
include('config.php');

if (isset($_GET['pass'])) 
{
	$pass = $_GET['pass'];
	$status = $_GET['status'];
	$sql = "UPDATE `driver` SET `status`=$status WHERE `driver_id`='$pass'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "home.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "home.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
}

?>