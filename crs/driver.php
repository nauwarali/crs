<?php include('config.php');
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

$currentPage = $_SERVER["PHP_SELF"];

$username = $_SESSION["username"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;
$admin_id = $row_admin['admin_id'];

if ($row_admin['type'] == 0) 
{
$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE status <> 3");
$row_driver = $query_driver->fetch_assoc();
$totalRows_driver = $query_driver->num_rows;
  
}
else
{ 
$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE driver_id='$admin_id' AND status <> 3");
$row_driver = $query_driver->fetch_assoc();
$totalRows_driver = $query_driver->num_rows;
}

$query_rating = $mysqli->query("SELECT * FROM `rating` WHERE admin_id='$admin_id'");
$row_rating = $query_rating->fetch_assoc();
$totalRows_rating = $query_rating->num_rows;

$average = 0;

if (isset($row_rating['id'])) 
{
  do
  {

    $average = $average + $row_rating['star'];

  }while($row_rating = $query_rating->fetch_assoc());

  $average = $average / $totalRows_rating;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>JOM SEWA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  if ($row_setting['style'] == 1) {
    echo "<link rel='stylesheet' href='vendor/style2.css'>";
  }
  else
  {
     echo "<link rel='stylesheet' href='vendor/style.css'>";
  };
  ?>
  
  <link rel="stylesheet" href="vendor/fontawesome.css">
  <link rel="stylesheet" href="vendor/style3.css">
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="content">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well">
        <h4 class="uppercase">Driver Manager</h4>
        <div class="table-responsive">
        <?php
        if (!isset($row_driver['id'])) 
        {
          ?>
            <a href="driver_add.php"><button class="btn btn-primary" style="width: 150px; float: right; margin-bottom: 10px;">Apply</button></a>
          <?php
        }
        ?> 
          <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Rate</th>
                <th style="width: 20%;">Expiry</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 25%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              do
              {
                $i++;
                ?>
                  <tr>
                    <td><?=$i?></td>
                    <td>
                      <?php
                      $j = 1;
                      do
                      {

                        if ($j <= $average) 
                        {
                          ?>
                            <span class="fa fa-star checked"></span>
                          <?php
                        }
                        else
                        {
                          ?>
                            <span class="fa fa-star"></span>
                          <?php
                        }
                        $j++;
                      }while($j <= 5);
                      ?>
                    </td>
                    <td><?=date('d M Y', strtotime($row_driver['expiry']))?></td>
                    <td><?php if($row_driver['status'] == 1){echo "Active";}elseif($row_driver['status'] == 2){echo "Pending";}elseif($row_driver['status']==0){ echo "Not Active";}else{echo "Rejected";};?></td>
                    <td>
                      <?php
                      if ($row_admin['type'] == 0) 
                      {
                        ?>
                        <a href="driver_view2.php?pass=<?=$row_driver['driver_id']?>"><button class="btn btn-round btn-primary"><i class="icon fas fa-eye"></i></button></a>
                        <?php
                      }
                      else
                      {
                        ?>
                        <a href="driver_view.php?pass=<?=$row_driver['driver_id']?>"><button class="btn btn-round btn-primary"><i class="icon fas fa-eye"></i></button></a>
                        <?php
                      }
                      ?>
                      
                      <a href="driver_edit.php?pass=<?=$row_driver['driver_id']?>"><button class="btn btn-round btn-success"><i class="icon fas fa-edit"></i></button></a>
                      <a href="driver_delete.php?pass=<?=$row_driver['driver_id']?>"><button class="btn btn-round btn-danger"><i class="icon fas fa-trash"></i></button></a>
                    </td>
                  </tr>
                <?php

              }while($row_driver = $query_driver->fetch_assoc());
              ?>
              
            </tbody>
          </table>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
