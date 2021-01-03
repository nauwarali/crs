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

$admin_id = $row_admin['admin_id'];

if (isset($_POST['date'])) 
{
  extract($_POST);

  $sewa_id = md5($date.microtime(true));

  $datetime = date('Y-m-d H:i:s', strtotime($date." ". $time));

  $day_start = date('Y-m-d 00:00:00', strtotime($date));

  $day_end = date('Y-m-d 23:59:59', strtotime($date));

  $start = $datetime;

  $end = date('Y-m-d H:i:s', strtotime($start.$hour.'hours'));

  $query_sewa = $mysqli->query("SELECT * FROM `sewa` WHERE car_id='$car_id' AND (datetime_start BETWEEN '$day_start' AND '$day_end')");
  $row_sewa = $query_sewa->fetch_assoc();
  $totalRows_sewa = $query_sewa->num_rows;

  $tt = 1;

  do
  {

    if (strtotime($datetime) > strtotime($row_sewa['datetime_start']) && strtotime($datetime) < strtotime($row_sewa['datetime_end']))
    {
      $tt = 0;
      break;
    }

    if (strtotime($row_sewa['datetime_start']) < strtotime($end) && strtotime($row_sewa['datetime_end']) > strtotime($end)) 
    {
      $tt = 0;
      break;
    }

  }while($row_sewa = $query_sewa->fetch_assoc());

  if ($tt == 1) 
  {
    $query_car = $mysqli->query("SELECT * FROM `car` WHERE car_id='$car_id'");
    $row_car = $query_car->fetch_assoc();
    $totalRows_car = $query_car->num_rows;

    $owner_id = $row_car['admin_id'];

    $sql = "INSERT INTO `sewa`(`datetime_start`, `hour`, `datetime_end`, `car_id`, `status`, `customer_id`, `owner_id`, `sewa_id`) VALUES ('$datetime', '$hour', '$end', '$car_id',0, '$admin_id', '$owner_id', '$sewa_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "booking.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "booking.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
  }
  else
  {
    $insertGoTo = "booking.php?notif=booked";
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
  <link rel="stylesheet" href="vendor/timepicker.min.css">
  <script src="vendor/jquery2.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="vendor/sweetalert2.css" rel="stylesheet">
</head>
<style type="text/css">
  .input-group-addon {
    padding: 6px 6px 6px 18px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #555555;
    text-align: center;
    background-color: #eeeeee;
    border: 1px solid #ccc;
    border-radius: 0px;
}

.timepicker{
  .form-control {
    background: #fff;
  }
}

.btn {
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: normal;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -ms-touch-action: manipulation;
      touch-action: manipulation;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="row content" style="margin-right: 0px; margin-left: 0px;">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well row" style="width: 50%; margin: auto;">
        <h4 class="uppercase">Sewa Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="sewa.php" method="POST" enctype="multipart/form-data">

            <label for="uname"><b>Date</b></label>
            <div class="input-group date" data-provide="datepicker" style="margin-top: 0; margin-bottom: 10px; border-radius: 0px;">
                <input name="date" type="text" class="form-control" style="border-radius: 0px; height: 50px;">
                <div class="input-group-addon">
                    <i class="icon fas fa-calendar"></i>
                </div>
            </div>

            <label for="uname"><b>Start Time</b></label>
              <div class="input-group clockpicker" style="margin-top: 0; margin-bottom: 10px; border-radius: 0px;">
                  <input name="time" type="text" class="form-control" value="09:30" style="border-radius: 0px; height: 50px;">
                  <span class="input-group-addon">
                      <i class="icon fas fa-clock"></i>
                  </span>
              </div>

            <label for="uname"><b>Hour(s)</b></label>
            <input name="hour" value="1" type="number" class="street form-control" style="margin-bottom: 10px; border-radius: 0px; height: 50px;" />

            <label for="uname"><b>Car</b></label>
            <select name="car_id" class="form-control" style="border-radius: 0px; height: 50px;">
              <?php

              $query_car = $mysqli->query("SELECT * FROM `car` WHERE status=1");
              $row_car = $query_car->fetch_assoc();
              $totalRows_car = $query_car->num_rows;

              do
              {

                ?>
                <option value="<?=$row_car['car_id']?>"><?=$row_car['car_model']?> ( <?=$row_car['transmission']?> - <?=$row_car['color']?> )</option>
                <?php

              }while($row_car = $query_car->fetch_assoc());
              ?>
            </select>
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary form-control" style="height: 50px; border-radius: 0px;">Rent</button>
              <a href="driver.php"><button type="button" class="btn btn-white form-control" style="height: 50px; border-radius: 0px;">Cancel</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="vendor/sweetalert2.js"></script>
<script src="vendor/bootstrap-datepicker.js"></script>
<script src="vendor/moment.js"></script>
<script src="vendor/timepicker.min.js"></script>
<script type="text/javascript">
  $('.datepicker').datepicker();
</script>
<script type="text/javascript">
$('.clockpicker').clockpicker({
    placement: 'right',
    align: 'left',
    donetext: 'Done'
});
</script>
<?php if (isset($_GET['notif'])) { ?>
<?php $notif = $_GET['notif']; if ($notif == "booked") { ?>
    <script type="text/javascript">
      $(document).ready(function () {
      swal({
        type: 'error',
        title: 'Car and Date Already Booked!',
      });
      });
    </script>
  <?php } ?>

    <?php } ?>
</body>
</html>
