<?php 
include('config.php');

if (isset($_GET['pass'])) 
{
	$pass = $_GET['pass'];
	$sql = "DELETE FROM admin WHERE `admin_id`='$pass'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "user.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "user.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
}

?>