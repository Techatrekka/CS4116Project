<!DOCTYPE HTML>
<?php
include 'header.php';
include 'database.php'
?>
<html>
<head>
	<title>EmployMe</title>
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
			<p>
			<form action="registerUser.php" method="post">
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" <?php if (isset($email) && !str_contains($email,"@")) 
				{echo "not a valid email address";}?> placeholder="Email" id="email" required>
				<br>
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<br>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<br>
				<input type="submit" value="Login" class="registerbtn">
			</form>
			</p>
			</div>
			<div class="col">
			</div>
		</div>	
	</div>
	<?php 
    include 'footer.php';
    ?>
</body>
</html>