<?php require_once('config.php');
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

if (isset($_POST['export_type']) && $_POST['export_type'] == 'excel') 
{
  header('report_income2.php?date_from='.$_POST['date_from'].'&date_to='.$_POST['date_to']);
}


$currentPage = $_SERVER["PHP_SELF"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

if (isset($_POST['date_from'])) 
{
  $from = $_POST['date_from'];
  $to = $_POST['date_to'];

  $query_taxi = $mysqli->query("SELECT * FROM `taxi` WHERE driver_id = '$admin_id' AND status = 2");
  $row_taxi = $query_taxi->fetch_assoc();
  $totalRows_taxi = $query_taxi->num_rows;

}

if (isset($_POST['type']) && $_POST['type'] == "excel") 
{
  header('Location: report_income2.php?date_from='.$from.'&date_to='.$to);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Jom Sewa Income Report</title>
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/favicon.png" />
  <link rel="stylesheet" href="css/all.css">
</head>
<style>

  .table.table-bordered thead 
  {
    border: 1px solid #252525;
    background-color: #dcdcdc;
  }
  .table-bordered th, .table-bordered td {
    border: 1px solid #252525;
}
.table thead th, td {
    vertical-align: bottom;
    border-bottom: 1px solid #252525;
    height: 30px;
}
</style>

<body onload="window.print(); window.close();">
  <div style="padding-right: 100px;padding-left: 100px;">
<h3 style="text-align: center;">INCOME REPORT</h3>


                    <table class="table table-bordered" style="border: 1px solid #252525; width: 100%;border-collapse: collapse;">
                      <thead>
                        <tr>
                          <th class="color" colspan="3" style="background-color: #dcdcdc; text-align: center; width: 10%; text-transform: uppercase; font-weight:bold;">
                            <?php echo date('d M Y', strtotime($from)); ?> TO <?php echo date('d M Y', strtotime($to)); ?>
                          </th>
                        </tr>
                        <tr>
                          <th class="color" style="text-align: center; width: 10%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            #
                          </th>
                          <th class="color" style="text-align: center; width: 40%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            Date
                          </th>
                          <th class="color" style="text-align: center; width: 25%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            Amount
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        $total = 0;
                        do
                        {
                          $i++;
                          ?>
                          <tr>
                          <td style="text-align: center; width: 10%; text-transform: uppercase;">
                            <?=$i?>
                          </td>
                          <td style="text-align: center; width: 40%; text-transform: uppercase;">
                            <?=date('d M Y', strtotime($row_taxi['datetime']))?>
                          </td>
                          <td style="text-align: center; width: 25%; text-transform: uppercase;">
                            RM <?=number_format($row_taxi['amount'], 2)?>
                            <?php
                            $total = $total + $row_taxi['amount'];
                            ?>
                          </td>
                        </tr>
                          <?php

                        }while($row_taxi = $query_taxi->fetch_assoc());
                        ?>

                        <tr>
                          <td colspan="2" style="text-align: center; width: 40%; text-transform: uppercase;">
                            TOTAL
                          </td>
                          <td style="text-align: center; width: 25%; text-transform: uppercase;">
                            RM <?=number_format($total, 2)?>
                          </td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                    <br>
                    <br>

                    
                    </div>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/all.js"></script>

</body>

</html>