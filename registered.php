<!DOCTYPE HTML>
<?php
include './nav_bar/header.php';
include 'database.php';
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
	<div class="row align-items-center" style="padding-top:150px;padding-bottom:150px;">
		<div class="col">
		</div>
		<div class="col">
			<h1 style="color:#f3b400">Thanks For Registering! <?php echo $_POST["fullname"]?></h1>
			<h3 style="color:#f3b400">Please proceed to the login page to login in to your new account!</h3>
			<?php
			$details = Array();
			$details[0] = $_POST["fullname"];
			$details[1] = $_POST["email"];
			$details[2] = $_POST["password"];
			$details[3] = $_POST["userType"];
			if ($details[3] != 'business') {
				$details[3] = "regular";
			}
			for ($i = 0; $i < count($details); $i++) {
				$details[$i] = "\"".$details[$i]."\"";
			}
			$query = "INSERT INTO users(full_name, email, password, user_type)
			Values(".$details[0].",".$details[1].",".$details[2].",".$details[3].");";
			$conn->query($query);
			?>
		</div>
		<div class="col">
		</div>
	</div>
</div>
<?php
include './nav_bar/footer.php';
?>
</body>
</html>