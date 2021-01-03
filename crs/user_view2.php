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

$pass = $row_admin['admin_id'];

$query_admin2 = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$pass'");
$row_admin2 = $query_admin2->fetch_assoc();
$totalRows_admin2 = $query_admin2->num_rows;

$query_wallet = $mysqli->query("SELECT *, SUM(balance) FROM `wallet` WHERE user_id='$pass'");
$row_wallet = $query_wallet->fetch_assoc();
$totalRows_wallet = $query_wallet->num_rows;

$query_taxi = $mysqli->query("SELECT *, SUM(point) FROM `taxi` WHERE customer_id='$pass'");
$row_taxi = $query_taxi->fetch_assoc();
$totalRows_taxi = $query_taxi->num_rows;

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
        <h4 class="uppercase">User Manager</h4>
        <div class="col-sm-12">
          <div style="background-color:#fff; border: 1px solid #dcdcdc; padding: 10px; width: 50%; text-align: center; margin: auto; box-shadow: 0px 5px 5px #dcdcdc">
            <label style="text-align: center; font-size: 20px; display: block;">BALANCE</label>
            <label style="text-align: center; font-size: 20px; display: block;">RM <?=number_format($row_wallet['SUM(balance)'], 2)?></label>
            
          </div>
          
          <br>

            <label class="new-row" for="uname"><b>Full Name :<pre><?=$row_admin['fullname']?></pre></b></label><br>
            <label class="new-row" for="uname"><b>Matric ID : <pre><?=$row_admin['matric_id']?></pre></b></label><br>
            <label class="new-row" for="uname"><b>Username : <pre><?=$row_admin['username']?></pre></b></label><br>
            <label class="new-row" for="uname"><b>Email : <pre><?=$row_admin['email']?></pre></b></label><br>
            <label class="new-row" for="uname"><b>Contact : <pre><?=$row_admin['contact']?></pre></b></label><br>

            <br>
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <a href="home.php"><button class="btn btn-white">BACK</button></a>
              <a href="user_edit.php?pass=<?=$row_admin['admin_id']?>"><button class="btn btn-primary">EDIT</button></a>
              <a href="user_delete.php?pass=<?=$row_admin['admin_id']?>"><button class="btn btn-danger">DELETE</button></a>
            </div>
            

          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
