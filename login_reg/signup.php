<!DOCTYPE HTML>
<?php
require '../nav_bar/header.php';
require '../database.php';
session_start();
if(isset($_SESSION['valid'])) {
        header("Location: ../index.php");
} 
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
			<div class="col" style="color:#f3b400;">
			<h1>Register and Grow Your Network<br></h1>
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
	
	if (isset($_POST['submit'])) {
	  if (empty($_POST["fullname"])) {
		$nameErr = "Name is required";
	  } else {
		$name = test_input($_POST["fullname"]);
		if (!preg_match("/^[a-z0-9A-Z-'.() ]*$/",$name)) {
		  $nameErr = "Invalid name format";
          print "Invalid name format - please ensure name only contains upper or lowercase letters, numbers, spaces, or '.<br>";
		}
	  }
	  if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	  } else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $emailErr = "Invalid email format";
          print "Invalid email format - please ensure email address includes @ and .<br>";
		}
	  }
	  if (empty($_POST["password"])) {
		$passwordErr = "Password is required";
	  } else {
		$password = test_input($_POST["password"]);
        $confirmPass = test_input($_POST["password2"]);
        if ($password != $confirmPass) {
		  $passwordErr = "Passwords don't match";
          print "Passwords don't match - please enter the the same password twice.<br>";
		}
		if (!preg_match("/^[a-z0-9A-Z-'@,#.!]*$/",$password)) {
		  $passwordErr = "Invalid password format";
          print "Invalid password format - please ensure password only contains upper or lowercase letters, numbers, or these special characters: '@#,.!<br>";
		}
        if(!(preg_match('/[a-z]/', $password)) ||    
                !(preg_match('/[A-Z]/', $password)) 
             || !(preg_match('/[0-9]/',$password))) { // at least one number
                $passwordErr = "Invalid password format";
                print "Invalid password format - password must contain at least one upper and lower case letter and at least one number"; 
        } 
        if(strlen($password) < 8) {
            $passwordErr = "Password too short";
            print "Password must be 8 characters minimum, please try again.<br>";
        }
	  }
      if (isset($_POST['email'])) {
                $email = $_POST['email'];
                $getEmails = "select email from users";
                $emailsResult = $conn->query($getEmails);
                $isUnique = true;
                while($row = $emailsResult->fetch_assoc()) {
                    if($email == $row['email']) {
                        $isUnique = false;
                        $emailErr = "Email is not unique";
                        print "The email you entered is already registered with the site. Please login if this is your account or use a different email to create a new account.<br>";
                    }
                }
        }
        if($nameErr == "" && $emailErr == "" && $passwordErr == "") {
            if (isset($_POST["fullname"])) {
                $fullname = $_POST['fullname'];
            }			
            if (isset($_POST['userType'])) {
                $userType = $_POST['userType'];
            }
            if (isset($_POST['password'])) {
                $password = $_POST['password'];
            }
            if ($userType != "business") {
                $userType = "regular";
            }
            $query = "INSERT INTO users(full_name, email, password, user_type) Values(\"$fullname\", \"$email\",\"$password\",\"$userType\");";
            $conn->query($query);
            header('Location: http://www.employmee.epizy.com/login_reg/registered.php');
	    } else {
            if (isset($_POST["fullname"])) {
                $keepFullname = $_POST['fullname'];
            }			
            if (isset($_POST['email'])) {
                $keepEmail = $_POST['email'];
            }
            if (isset($_POST['userType'])) {
                $keepUserType = $_POST['userType'];
            }
        }
	}
	?>
			<form method="post" action="">
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="Email" id="email" <?php print "value=\"{$keepEmail}\""; ?>required>
				<label for="Fullname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="fullname" placeholder="Full Name" id="fullname" <?php print "value=\"{$keepFullname}\""; ?> required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password2" placeholder="Re-enter Password" id="password2" required>
				<label for="userType" style="color:#f3b400">Are you a Business User?*</label>
                <input type="checkbox" id="userType" name="userType" value="business" <?php if($keepUserType == "business") { print "checked"; } ?> >
                <p style="color:#f3b400">*Business Users are able to create companies on the site in addition to the regular user functionality</p>
				<input type="submit" name="submit" value="Register" class="registerbtn">
			</form>
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