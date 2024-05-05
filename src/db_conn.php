<?php
$host = "localhost"; // Host name
$uname = "root"; // Mysql username
$password = ""; // Mysql password
$dbname = "hospital"; // Database name

// Create connection
$conn = mysqli_connect($host, $uname, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
