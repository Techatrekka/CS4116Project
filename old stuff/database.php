<?php //database.php
$servername = "sql300.epizy.com";
$username = "epiz_28116725";
$password = "wFwMZuLQFmgmp1S";
$dbname = "epiz_28116725_employmee";
$conn = new mysqli($servername, $username, $password,$dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
#echo "Connected successfully";

?>