<!DOCTYPE html>
<?php
	include "./nav_bar/header.php";
	include "database.php";
	ob_start();
	session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
	</head>
	<body>
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
		<div class="container-fluid" style="background-color:MidnightBlue;">
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            if (isset($_POST['login']) && !empty($_POST['email']) 
               && !empty($_POST['password'])) {
				   $sqlCheck = "SELECT email, ban_status, user_id FROM users WHERE email =\"".$_POST["email"]."\"AND password = \"".$_POST["password"]."\";";
					$msg = $conn->query($sqlCheck);
					while($row = $msg->fetch_assoc()) {
						$user_id = $row["user_id"];
						$email = $row["email"];
						$ban_status = $row["ban_status"];
					}
				
				if ($user_id != null && $ban_status == "not-banned") {
				  $_SESSION['valid'] = true;
				  $_SESSION['timeout'] = time();
				  $_SESSION["email"] = $email;
				  $_SESSION["user_id"] = $user_id;
				  
				  echo 'You have entered a valid use name and password';
				  //header("Location: http://www.example.com/another-page.php");
				}else if($user_id != null) {
					echo 'You banned scrub';
				}
				else {
				  $msg = 'Wrong email or password';
				}
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container" style="padding-top:150px;padding-bottom:150px;">
      		<h2 style="color:#f3b400">Login Here</h2> 
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "email" placeholder = "email" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
         <form action="/signup.php" style="padding-top:30px;" class="form-signin">
			<button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "Register"> Or Register Here!</button>
		</form>
      </div> 
	  	  </div>
	  <?php
		include "./nav_bar/footer.php";
	  ?>
	</body>
</html>