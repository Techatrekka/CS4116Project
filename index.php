<html>
<head>
<title>EmployMee</title>
</head>
<body>
<?php
$servername = "sql201.epizy.com";
$username = "epiz_28051136";
$password = "33mkLIcjQzUnDp";
$dbname = "epiz_28051136_test";
$conn = new mysqli($servername, $username, $password,$dbname);// Check connection
if ($conn->connect_error) {    
die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$sql = "select * from modules;";
$result = $conn->query($sql); 
while($row = $result->fetch_assoc())   {    
print "{$row["code"]}:{$row["name"]}\n";  
}
$conn->close();
?>
<p>This is a website!</p>
</body>
</html>