<html>
<head>
<title>EmployMee</title>
</head>
<body>
<?php
$servername = "sql300.epizy.com";
$username = "epiz_28116725";
$password = "wFwMZuLQFmgmp1S";
$dbname = "epiz_28116725_employmee";
$conn = new mysqli($servername, $username, $password,$dbname);// Check connection
if ($conn->connect_error) {    
die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$sql = "SELECT user_id, email, password FROM users WHERE email =\"test@email.com\"AND password = \"passs\";";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
	print "<b>About: </b><br>{$row["user_id"]}";
}
echo "Hello";
$conn->close();
?>
<p>This is a website!</p>
</body>
</html>