<?php include('config.php');?>
<?php

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
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

$query_announcement = $mysqli->query("SELECT * FROM `announcement` ORDER BY datetime DESC");
$totalRows_announcement = $query_announcement->num_rows;

$query_car = $mysqli->query("SELECT * FROM `car` WHERE status=1");
$totalRows_car = $query_car->num_rows;

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
  <link rel="stylesheet" href="vendor/modalcss.css">
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<style type="text/css">
  .rating {
    float:left;
    text-align: center;
    margin: auto;
}
.rating span { float:right; position:relative; }
.rating span input {
    position:relative;
    top:0px;
    left:0px;
    opacity:0;
}
.rating span label {
    display:inline-block;
    text-align:center;
    color:#333333;
    background:#fff;
    -webkit-border-radius:50%;
}
.rating span:hover ~ span label,
.rating span:hover label,
.rating span.checked label,
.rating span.checked ~ span label {
    background:#fff;
    color:#F90;
}
</style>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="content">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>


  <div class="container col-sm-10">
      <div class="well">
        <h4>Announcement</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 95%; text-align: left;">Title</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_announcement = $query_announcement->fetch_assoc())
              {
              
                if (strtotime(date('Y-m-d H:i:s')) > strtotime($row_announcement['datetime']."+ 7 days")) 
                {
                  
                }
                else
                {
                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td style="text-align: left;"><a rel="noopener noreferrer" target="_blank" href="" onClick="window.open('news.php?pass=<?=$row_announcement['announcement_id']?>','pagename',',height=500,width=500'); return false;"><?=$row_announcement['title']?></a></td>
                  </tr>
                  <?php
                }
                ?>
                  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>

      <div class="well">
        <h4>Available Car for Rent</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 45%; text-align: left;">Car Model</th>
                <th style="width: 25%; text-align: left;">Plat Number</th>
                <th style="width: 25%; text-align: left;">Transmission</th>
                <th style="width: 25%; text-align: left;">Colour</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_car = $query_car->fetch_assoc())
              {
                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_car['car_model']?></td>
                    <td><?=$row_car['car_plat']?></td>
                    <td><?=$row_car['transmission']?></td>
                    <td><?=$row_car['color']?></td>
                  </tr>
  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>
    
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</body>
</html>
