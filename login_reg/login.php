<!DOCTYPE html>
<?php
	require "../nav_bar/header.php";
	require "../database.php";
	ob_start();
    session_start();
    if(isset($_SESSION['valid'])) {
        header("Location: ../index.php");
    } 
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<style>
         
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

        /* Set a style for the login/register buttons */
        .buttons {
        background-color: #f3b400;
        color: white;
        padding: 16px 20px;
        margin: 5px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
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
				   $sqlCheck = "SELECT email, ban_status, user_id, user_type FROM users WHERE email =\"".$_POST["email"]."\"AND password = \"".$_POST["password"]."\";";
                    $userEmail = $_POST["email"];
					$queryResult = $conn->query($sqlCheck);
					while($row = $queryResult->fetch_assoc()) {
						$user_id = $row['user_id'];
						$email = $row['email'];
						$ban_status = $row["ban_status"];
                        $user_type = $row["user_type"];
					}
				
				if ($user_id != null && $ban_status == "not-banned") {
				  $_SESSION['valid'] = true;
				  $_SESSION['timeout'] = time();
				  $_SESSION['email'] = $email;
				  $_SESSION['user_id'] = $user_id;
                  $_SESSION['user_type'] = $user_type;
                  header("Location: ../profile/profile_page.php?$user_id");
				  
				} else if($user_id != null) {
					$msg = 'You can\'t log in - you\'re banned';
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
            action = "" method = "post">
            <h4 class = "form-signin-heading" style="color:#f3b400"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "email" placeholder = "Email"  <?php print "value=\"{$userEmail}\""; ?>
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "Password" required>
            <button class = "buttons" type = "submit" 
               name = "login" style="margin-top:20px;">Login</button>
         </form>
         <form action="signup.php" style="padding-top:10px;" class="form-signin">
			<button class = "buttons" type = "submit" 
               name = "Register"> Or Click Here To Register!</button>
		</form>
      </div> 
	  	  </div>
	  <?php
		include "../nav_bar/footer.php";
	  ?>
	</body>
</html>