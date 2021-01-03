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
  
  $logotemp = md5($_POST['expiry']);
  $dir="img/receipt/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = $admin_id.".pdf";
  $dir2=$dir.$newfilename;
  $dir3="img/receipt/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}
    
  $maintenance_id = md5($air_filter.microtime(true));

  $date2 = date('Y-m-d', strtotime($date));

  $sql = "INSERT INTO `driver`(`driver_id`, `expiry`, `nationality`, `licence_number`, `status`, `licence_copy`) VALUES ('$admin_id', '$expiry', '$nationality', '$licence_number', 2, '$dir3')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "driver.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "driver.php?notif=failed";
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
        <h4 class="uppercase">Taxi Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="taxi2.php" method="POST" enctype="multipart/form-data">

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

            <label for="uname"><b>Pickup</b></label>
            <input id="autocomplete" placeholder="Enter Pickup" type="text" class="street" name="pickup" />

            <label for="uname"><b>Destination</b></label>
            <input id="autocomplete2" placeholder="Enter Destination" type="text" class="to_street" name="destination" />

            <input type="hidden" name="driver_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary" style="height: 50px; border-radius: 0px;">Book</button>
              <a href="driver.php"><button type="button" class="btn btn-white" style="height: 50px; border-radius: 0px;">Cancel</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>
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
<script>
      var placeSearch, autocomplete, geocoder;

function initAutocomplete() {
  geocoder = new google.maps.Geocoder();
  autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('autocomplete'))
      );

  autocomplete.setComponentRestrictions(
            {'country': ['my']});

  autocomplete.addListener('place_changed', fillInAddress);

  autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('autocomplete2'));
google.maps.event.addListener(autocomplete2, 'place_changed', function() {
  fillInAddress();
});
}

function codeAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        alert(results[0].geometry.location);
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

function fillInAddress() {
  var place = autocomplete.getPlace();
  
}
    </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsSCQtzMCTYTsN6KzWYpgpt3gsEO7qnC8&libraries=places&types=establishment&types=address&callback=initAutocomplete&locality=my" async defer></script>

   <script type="text/javascript">
      $("#from_button").click(function(){
        var building = $('.building').val(); 
        var unit = $('.unit').val();
        var street = $('.street').val();
      $("#from_building").val(building);
       $("#from_unit").val(unit);
       $("#from_street").val(street);
       $("#from").val(street);
    });

    </script>

    <script type="text/javascript">
      $("#to_button").click(function(){
        var building = $('.to_building').val(); 
        var unit = $('.to_unit').val();
        var street = $('.to_street').val();
      $("#to_building").val(building);
       $("#to_unit").val(unit);
       $("#to_street").val(street);
       $("#to").val(street);
    });

    </script>


</body>
</html>
