<!DOCTYPE HTML>
<?php
include '../nav_bar/header.php';
include '../database.php'
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
	<style>
	/* Full-width input fields */
	input[type=text], input[type=password] {
	  width: 100%;
	  padding: 15px;
	  margin: 5px 0 22px 0;
	  display: inline-block;
	  border: none;
	  background: #f1f1f1;
	}

	input[type=text]:focus, input[type=password]:focus {
	  background-color: #ddd;
	  outline: none;
	}

	/* Set a style for the submit/register button */
	.registerbtn {
	  background-color: #f3b400;
	  color: white;
	  padding: 16px 20px;
	  margin: 20px 0;
	  border: none;
	  cursor: pointer;
	  width: 100%;
	  opacity: 0.9;
	}
	</style>
</head>
<body>
	<div class="container-fluid" style="background-color:MidnightBlue;padding-top:150px;padding-bottom:150px;">
		<div class="row align-items-center">
			<div class="col">
			</div>
			<div class="col">
			<h1 style="color:#f3b400;">Register and Grow Your Network</h1>
			<form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder=<?php $emailErr = $_POST["email"]; if(isset($emailErr)) {echo $emailErr;} else {echo "Email";}?> id="email" required>
				<label for="Fullname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="fullname" placeholder="Fullname" id="fullname" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<label for="userType" style="color:#f3b400">Are you a Business User?</label>
                <input type="checkbox" id="userType" name="userType" value="business">
				<input type="submit" value="Register" class="registerbtn">
			</form>
			</div>
			<div class="col">
			</div>
		</div>	
	</div>
	<?php
		$nameErr = "";
		$emailErr = "";
		$passwordErr = "";
		$password = "";
		$name = "";
		$email = "";
	
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (empty($_POST["fullname"])) {
		$nameErr = "Name is required";
	  } 
	  if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	  } else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Invalid email format";
		}
	  }
	  if (empty($_POST["password"])) {
		$passwordErr = "Password is required";
	  } else {
		$password = test_input($_POST["password"]);
		if (!preg_match("/^[a-z0-9A-Z-' ]*$/",$password)) {
		  $passwordErr = "Invalid password format";
		}
	  }
	  if($nameErr == "" && $emailErr == "" && $passwordErr == "") {
		setcookie("fullname", $_POST["fullname"], time()+5);
		setcookie("email", $_POST["email"], time()+5);
		setcookie("userType", $_POST["userType"], time()+5);
		setcookie("password", $_POST["password"], time()+5);
		header('Location: http://www.employmee.epizy.com/login_reg/registered.php');
	}
	}
	?>
	<?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>