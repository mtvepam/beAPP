<?php
include 'dbcred.php';
$check_conn = mysqli_connect($db_server, $db_username, $db_password); 
$check_table = "CREATE TABLE IF NOT EXISTS Weather.Days (id varchar(100) NULL, weather_state_name varchar(100) NULL, wind_direction_compass varchar(100) NULL, created varchar(100) NULL, applicable_date varchar(100) NULL,	min_temp FLOAT NULL,	max_temp FLOAT NULL, the_temp FLOAT NULL)";
$check_buffer = "CREATE TABLE IF NOT EXISTS Weather.Buffer (id varchar(100) NULL, weather_state_name varchar(100) NULL, wind_direction_compass varchar(100) NULL, created varchar(100) NULL, applicable_date varchar(100) NULL,	min_temp FLOAT NULL,	max_temp FLOAT NULL, the_temp FLOAT NULL)";
if (mysqli_query($check_conn, $check_table) && mysqli_query($check_conn, $check_buffer))
  {
    $connect = mysqli_connect($db_server, $db_username, $db_password, $db_name); 
  }
else
  {
    die ("Error: " . mysqli_error($check_conn));
  }
if (!$connect) 
  {
    die("Error: " . mysqli_connect_error());
  }
?>
