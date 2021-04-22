<!DOCTYPE HTML>
<?php
include '../nav_bar/header.php';
include '../database.php';
?>
<html>
<head>
	<title>EmployMee</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" 
	crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
	integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" 
	crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid" style="background-color:MidnightBlue;">
	<div class="row align-items-center" style="padding-top:200px;padding-bottom:200px;">
		<div class="col">
		</div>
		<div class="col">
			<h1 style="color:#f3b400">Thanks For Registering! <?php echo $_POST["fullname"]?></h1>
			<h3 style="color:#f3b400">Please proceed to the login page to login in to your new account!</h3>
			<?php			
			$details = Array();
			if (isset($_COOKIE['fullname'])) {
				$details[0] = $_COOKIE['fullname'];
			}			
			if (isset($_COOKIE['email'])) {
				$details[1] = $_COOKIE['email'];
			}
			if (isset($_COOKIE['userType'])) {
				$details[2] = $_COOKIE['userType'];
			}
			if (isset($_COOKIE['password'])) {
				$details[3] = $_COOKIE['password'];
			}
			if ($details[2] != "business") {
				$details[2] = "regular";
			}
			for ($i = 0; $i < count($details); $i++) {
				$details[$i] = "\"".$details[$i]."\"";
			}
			$query = "INSERT INTO users(full_name, email, password, user_type)
			Values(".$details[0].",".$details[1].",".$details[3].",".$details[2].");";
			$conn->query($query);
			?>
		</div>
		<div class="col">
		</div>
	</div>
</div>
<?php
include '../nav_bar/footer.php';
?>
</body>
</html>