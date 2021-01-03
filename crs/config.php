<?php

$hostname_jomsewa = "localhost";
$database_jomsewa = "jomsewa";
$username_jomsewa = "root";
$password_jomsewa = "";
$mysqli = new mysqli($hostname_jomsewa, $username_jomsewa, $password_jomsewa, $database_jomsewa); 

$query_setting = $mysqli->query("SELECT * FROM `setting`");
$row_setting = $query_setting->fetch_assoc();
$totalRows_setting = $query_setting->num_rows;

?>