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

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$air_filter = 0;
$windshield_wiper = 0;
$spark_plug = 0;
$oil_filter = 0;
$battery = 0;
$radiator_flush = 0;
$brake_pads = 0;
$fuel_filter = 0;

if (isset($_POST['date'])) 
{
  extract($_POST);

  // A list of permitted file extensions
  $allowed = array('png', 'jpg', 'gif', 'pdf');


if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
  
  $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

  if(!in_array(strtolower($extension), $allowed)){
    echo '{"status":"error"}';
    exit;
  }
  
  $logotemp = md5($_POST['air_filter']);
  $dir="img/receipt/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = $_FILES["image"]["name"];
  $dir2=$dir.$newfilename;
  $dir3="img/receipt/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}
    
  $maintenance_id = md5($air_filter.microtime(true));

  $date2 = date('Y-m-d', strtotime($date));

  $sql = "INSERT INTO maintenance(`file`, `air_filter`, `windshield_wiper`, `spark_plug`, `oil_filter`, `battery`, `radiator_flush`, `brake_pads`, `fuel_filter`, `date`, `maintenance_id`, `admin_id`, car_id) VALUES ('$dir3', '$air_filter', '$windshield_wiper', '$spark_plug', '$oil_filter', '$battery', '$radiator_flush', '$brake_pads', '$fuel_filter', '$date2', '$maintenance_id', '$admin_id', '$pass')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "maintenance.php?pass=".$pass."&notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "maintenance.php?pass=".$pass."&notif=failed";
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
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
</style>
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
          <form action="maintenance_add.php" method="POST" enctype="multipart/form-data">
            <label for="uname"><b>Date</b></label>
            <div class="input-group date" data-provide="datepicker" style="margin-top: 0; margin-bottom: 10px; border-radius: 0px;">
                <input name="date" type="text" class="form-control" style="border-radius: 0px; height: 50px;">
                <div class="input-group-addon">
                    <i class="icon fas fa-calendar"></i>
                </div>
            </div>

            <label for="uname"><b>Receipt</b></label>
            <input type="file" placeholder="Enter Receipt" name="image" required value="">

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Air Filter</b></label>
                  <label class="switch" style=" text-align: center; margin: auto;">
                    <input type="checkbox" value="1" name="air_filter" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Windshield Wiper</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="windshield_wiper" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Oil Filter</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="oil_filter" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Battery</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="battery" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              
            </div>
            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Radiator Flush</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="radiator_flush" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Spark Plug</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="spark_plug" checked>
                    <span class="slider round"></span>
                  </label>
            </div>
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Brake Pads</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="brake_pads" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Fuel Filter</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="fuel_filter" checked>
                    <span class="slider round"></span>
                  </label>
            </div>
            </div>
            

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">SAVE</button>
              <a href="maintenance.php?pass=<?=$_GET['pass']?>"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>
<script src="vendor/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $('.datepicker').datepicker();
</script>
</body>
</html>
