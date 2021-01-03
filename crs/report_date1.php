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

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

if (isset($_POST['idd'])) 
{
  extract($_POST);

  $query_admin2 = $mysqli->query("SELECT * FROM `admin` WHERE matric_id='$idd'");
  $row_admin2 = $query_admin2->fetch_assoc();
  $totalRows_admin2 = $query_admin2->num_rows;

  $user_id = $row_admin2['admin_id'];

  $wallet_id = md5($user_id.microtime(true));

  if (isset($row_admin2['id'])) 
  {
     $sql = "INSERT INTO wallet(`balance`, `user_id`, `type`, `wallet_id`) VALUES ('$amount', '$user_id', 1, '$wallet_id')";

    if (mysqli_query($mysqli, $sql)) {
        $insertGoTo = "reload.php?notif=success";
        header(sprintf("Location: %s", $insertGoTo));
    } else {
        $insertGoTo = "reload.php?notif=failed";
        header(sprintf("Location: %s", $insertGoTo));
    }
  }
  else
  {
    $insertGoTo = "reload.php?notif=failed";
    header(sprintf("Location: %s", $insertGoTo));
  }

  

 
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
  <link rel="stylesheet" href="vendor/datepicker3.css">
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <script src="vendor/bootstrap-datepicker.js"></script>
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
          <form action="report_income.php" method="POST">

            <label style="display: block;" for="exampleInputPassword2" class=" col-form-label">Date</label>
                    <div class="input-group" style="width:100%; text-align: center; margin: auto;">
                        <input name="date_from" style="text-align: center; font-size: 15px; height: 50px;" type="text" class="form-control datepicker" value="<?=date('d-m-Y')?>">
                        <div class="input-group-addon" style="padding: 15px; background-color: #dcdcdc">To</div>
                        <input name="date_to" style="text-align: center; font-size: 15px; height: 50px;" type="text" class="form-control datepicker" value="<?=date('d-m-Y')?>">
                    </div>

            <label style="display: block;" for="exampleInputPassword2" class=" col-form-label">Export Type</label>
            <select name="type">
              <option value="pdf">PDF</option>
              <option value="excel">Excel</option>
            </select>

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">SAVE</button>
              <a href="car.php"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
    $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose : true,
});
  </script>
</body>
</html>
