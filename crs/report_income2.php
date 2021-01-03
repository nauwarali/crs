<?php

require_once('config.php');
session_start();

$from = date('Y-m-d 00:00:00', strtotime($_GET['date_from']));
$to = date('Y-m-d 23:59:59', strtotime($_GET['date_to']));

$filename = "Income Report (".date('d M Y', strtotime($from))." - ".date('d M Y', strtotime($to)).")";

$sql = "Select * from checkout"; 
$file_ending = "xls";
//header info for browser
header("Content-Type: application/csv");    
header("Content-Disposition: attachment; filename=$filename.csv");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = ","; //tabbed character
//start of printing column names as names of MySQL fields

    echo "#, Items, Amount";

print("\n");    

$username = $_SESSION["username"];

$colname_access_check = "-1";
if (isset($_SESSION['username'])) {
  $colname_access_check = $mysqli->real_escape_string($_SESSION['username']);
}

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username = '$username' ");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

$query_taxi = $mysqli->query("SELECT * FROM `taxi` WHERE driver_id = '$admin_id' AND status = 2");
$row_taxi = $query_taxi->fetch_assoc();
$totalRows_taxi = $query_taxi->num_rows;
$i = 0;
$tt2 = 0;
                  $schema_insert = "";
                            do
                            {
                              $i++;
                              
                              $schema_insert .= $i.", ";
                              $schema_insert .= date('d M Y', strtotime($row_taxi['datetime'])).", ";
                              $schema_insert .= number_format($row_taxi['amount'], 2).", "."\n";

                            $tt2 = $tt2 + $row_taxi['amount'];

                            }while($row_taxi = $query_taxi->fetch_assoc());
                            $schema_insert .= ", ".", ".number_format($tt2, 2).", "."\n";
                            print(trim($schema_insert));
                            print "\n";
                            
?>

