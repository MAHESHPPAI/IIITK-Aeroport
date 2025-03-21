<?php
$servername = "localhost";
$db_username = "root";
$db_password = "026414";
$db_name = 'airline';

$conn = mysqli_connect($servername, $db_username, $db_password,$db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

