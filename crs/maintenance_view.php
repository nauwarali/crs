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
$password = $_SESSION["password"];
$pass = $_GET['pass'];
$date = $_GET['date'];


$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

$query_maintenance = $mysqli->query("SELECT * FROM `maintenance` WHERE maintenance_id='$date'");
$row_maintenance = $query_maintenance->fetch_assoc();
$totalRows_maintenance = $query_maintenance->num_rows;

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
</head>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="row content" style="margin-right: 0px; margin-left: 0px;">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well row" style="width: 50%; margin: auto;">
        <h4 class="uppercase">Car Manager</h4>
        <div class="col-sm-12">
          <br>
            <label class="new-row" for="uname"><b>Maintenance Date :<pre><?=date('d M Y', strtotime($row_maintenance['date']))?></pre></b></label><br>

            <label class="new-row" for="uname"><b>Receipt :<pre><a target="_blank" href="<?=$row_maintenance['file']?>"><?=str_replace("img/receipt/","", $row_maintenance['file'])?></a></pre></b></label><br>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Air Filter</b></label>
                  <?php
                  if ($row_maintenance['air_filter'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Windshield Wiper</b></label>
                  <?php
                  if ($row_maintenance['windshield_wiper'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Oil Filter</b></label>
                  <?php
                  if ($row_maintenance['oil_filter'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Battery</b></label>
                  <?php
                  if ($row_maintenance['battery'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              
            </div>
            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Radiator Flush</b></label>
                  <?php
                  if ($row_maintenance['radiator_flush'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Spark Plug</b></label>
                  <?php
                  if ($row_maintenance['spark_plug'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
            </div>
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Brake Pads</b></label>
                  <?php
                  if ($row_maintenance['brake_pads'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Fuel Filter</b></label>
                  <?php
                  if ($row_maintenance['fuel_filter'] == 1) 
                  {
                    ?>
                      <button class="btn btn-round btn-success"><i class="icon fas fa-check"></i></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="btn btn-round btn-danger"><i class="icon fas fa-times"></i></button>
                    <?php
                  }
                  ?>
            </div>
            </div>
            

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <a href="maintenance.php?pass=<?=$pass?>"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
