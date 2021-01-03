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

$query_announcement = $mysqli->query("SELECT * FROM `announcement` ORDER BY datetime DESC");
$row_announcement = $query_announcement->fetch_assoc();
$totalRows_announcement = $query_announcement->num_rows;

if (isset($_POST['title'])) 
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
  
  $logotemp = md5($_POST['title']);
  $dir="img/announcement/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = round(microtime(true)) . $logotemp. '.' . end($temp);
  $dir2=$dir.$newfilename;
  $dir3="img/announcement/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}

  $announcement_id = md5($title.microtime(true));
  $datetime = date('Y-m-d H:i:s');

  $sql = "INSERT INTO announcement(title, image, announcement, datetime, status, announcement_id) VALUES ('$title', '$dir3', '$announcement', '$datetime',  1, '$announcement_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "announcement.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "announcement.php?notif=failed";
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


  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <script src="vendor/jquery3.js"></script> 
  <script src="vendor/bootstrap2.js"></script> 
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
  <script src="vendor/summernote.js"></script>

</head>
<style type="text/css">
  /* Full-width input fields */
input[type=text], input[type=password], input[type=file], input[type=date], input[type=time], input[type=number] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
</style>
<body style="background-color: #333333;">
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
  <div class="content">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">
      <form action="announcement_add.php" method="POST" enctype="multipart/form-data">
      <div class="well" style="background-color: #fff">
        <h4 class="uppercase text-color" style="color:#333333;">Announcement Manager</h4>

        <label for="uname"><b>Title</b></label>
            <input type="text" placeholder="Enter Title" name="title" required value="">

        <label for="uname"><b>Image</b></label>
            <input type="file" placeholder="Enter Image" name="image" required value="">

        <textarea id="summernote" name="announcement"></textarea>

        <button type="submit" style="width: 150px; height: 50px; background-color: #337ab7; border-radius: 0px;color: white;padding: 14px 20px;margin: 8px 0;border: none;cursor: pointer; margin: auto;">Publish</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
        });
        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "upload.php",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    editor.insertImage(welEditable, url);
                }
            });
        }
    });


</script>
</body>
</html>
