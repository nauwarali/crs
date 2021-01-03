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

if (isset($_POST['expiry'])) 
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
  
  $logotemp = md5($expiry);
  $dir="img/receipt/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = $driver_id.".pdf";
  $dir2=$dir.$newfilename;
  $dir3="img/receipt/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}
    
  $maintenance_id = md5($air_filter.microtime(true));

  $expiry = date('Y-m-d', strtotime($expiry));

  $sql = "UPDATE `driver` SET `licence_copy`='$dir3', `expiry`='$expiry' WHERE driver_id='$driver_id'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "driver.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "driver.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
}


$admin_id = $row_admin['admin_id'];
$driver_id = $_GET['pass'];

$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE driver_id='$driver_id'");
$row_driver = $query_driver->fetch_assoc();
$totalRows_driver = $query_driver->num_rows;

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
        <h4 class="uppercase">Driver Manager</h4>
        <div class="col-sm-12">
          <form action="driver_edit.php" method="POST" enctype="multipart/form-data">
          <br>
            <label class="new-row" for="uname"><b>Licence Number :<pre><?=$row_driver['licence_number']?></pre></b></label><br>

            <label class="new-row" for="uname"><b>Licence Copy :<pre><a target="_blank" href="<?=$row_driver['licence_copy']?>"><?=str_replace("img/receipt/","", $row_driver['licence_copy'])?></a></pre></b></label>
            <input type="file" placeholder="Enter Licence Copy" name="image" required value="" style="width: 100%; margin-left: 0; display: block;"><br>

            <label class="new-row" for="uname"><b>Expiry Date :<pre><?=date('d M Y', strtotime($row_driver['expiry']))?></pre></b></label>
            <input type="date" placeholder="Enter Expiry Date" name="expiry" required value="">
            <br><br>

            <label class="new-row" for="uname"><b>Nationality :<pre><?php if($row_driver['nationality'] == 1){echo 'Malaysian'; }else{echo "Foreigner";}?></pre></b></label><br>

            <input type="hidden" name="driver_id" value="<?=$row_driver['driver_id']?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">UPDATE</button>
              <a href="driver.php"><button type="button" class="btn btn-white">Back</button></a>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
