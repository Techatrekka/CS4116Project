<!DOCTYPE HTML>
<?php
session_start();
require 'header.php';
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
    <div class="container-fluid" style="background-color:MidnightBlue;padding-bottom:20px;color:#f3b400;">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <img src="/nav_bar/dreamteam.PNG"  alt="Logo" width="350" height="250" style="padding-top:30px; padding-bottom:20px; padding-left:50px;">
                <h1 style="text-align:center;">About EmployMee</h1>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>
	<div class="container-fluid" style="background-color:MidnightBlue;padding-bottom:50px;">
		<div class="row align-items-center">
			<div class="col-sm-3">
			</div>
			<div class="col-sm-6" style="color:#f3b400; text-align:center;">
			<p>
			EmployMee was created by a small but dedicated team of software engineers.<br><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lacinia at metus vel mollis. Mauris porttitor ex venenatis, blandit orci at, fringilla erat. Sed aliquam tincidunt mollis. Fusce ac vehicula mauris. Phasellus blandit sapien et libero tempor lacinia. Morbi sed tortor urna. Integer malesuada ultricies lectus a vulputate. In placerat, ipsum et venenatis porttitor, erat mauris sodales libero, vitae gravida mauris sem a mi. Aliquam eu rhoncus est. In eu bibendum sem. Vestibulum laoreet elit quam, quis interdum ligula faucibus ac.
<br><br>
Etiam viverra ipsum metus, suscipit euismod ligula tristique ut. Fusce sagittis molestie purus in hendrerit. Nam rhoncus blandit orci, non volutpat nisl pretium ut. In maximus pulvinar lobortis. Proin maximus volutpat augue at tempus. Sed ante nisi, posuere id tempor non, auctor varius purus. Nulla efficitur ipsum mi, vel tincidunt dolor rutrum at. Donec lacinia lectus erat. Aliquam tempus tincidunt lacus vitae dictum. Nullam nec aliquet turpis. Nullam tristique feugiat urna vitae lacinia. In pulvinar consectetur erat, porta facilisis mauris tincidunt eu. Suspendisse porta, nibh eu varius pharetra, risus enim tincidunt est, ac efficitur sapien ipsum quis mauris. Fusce placerat justo pulvinar erat pellentesque lobortis. Fusce pulvinar tincidunt est nec venenatis.
			</p>
			</div>
			<div class="col-sm-3">
			</div>
		</div>	
	</div>
	<?php 
    include 'footer.php';
    ?>
</body>
</html>