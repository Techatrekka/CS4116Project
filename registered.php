<!DOCTYPE HTML>
<?php
include 'header.php'
include 'database.php'
?>
<html>
<head>
</head>
<body>
<?php
$details = Array();
$details[0] = $_POST["fullname"];
$details[1] = $_POST["email"];
$details[2] = $_POST["password"];
$query = "INSERT INTO `users`(`Full name`, `email`,`password`) Values(".$details[0].",".$details[1].",".$details[2]".);"
$conn->query($sql);
?>
<?php
include 'footer.php'
?>
</body>
</html>