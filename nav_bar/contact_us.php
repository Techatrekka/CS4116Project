<?php
session_start();
require 'header.php';

$output = "";
if(isset($_POST['submit'])) {
    if(empty($_POST['subject'])){
        $output = "Please write something in the box";
    }
    if(empty($_POST['firstname'])){
        $output = "Please enter your first name";
    }
    if(empty($_POST['lastname'])){
        $output = "Please enter your last name";
    }
    if(!empty($_POST['subject']) and !empty($_POST['firstname']) and !empty($_POST['lastname'])) {
        $output = "Your message has been sent to the Dream Team!";
        // $emailTo = 'thedreamteamandmatt@gmail.com';
        // $subject = 'Contacting Dream Team';
        // $message = "testing"; //$_POST['subject'];
        // $from = "From: $emailTo\r\nReply-To: $emailTo\r\nReturn-Path: $emailTo\r\n";
        // mail('<thedreamteamandmatt@gmail.com>', $subject, $message, $from);
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <style>
        label{
            display:inline-block;
            }
        table, tr, td {
            width:50%;
            margin-left:auto;
            margin-right:auto;
            float:center;
            border:none !important;
            // vertical-align:bottom;
        }
        .col1{
            float:center;
            text-align:center;
        }
    </style>
    
	<title>EmployMee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" 
	crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" 
	integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" 
	crossorigin="anonymous"></script>

</head>
<body>
    <div class="container-fluid" style="background-color:MidnightBlue;padding-top:50px;padding-bottom:20px;color:#f3b400;">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <h1 class="col1">Get in touch with The Dream Team</h1>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>
	<div class="container-fluid" style="background-color:MidnightBlue;padding-bottom:50px;">
		<div class="row align-items-center">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4" style="color:#f3b400;">
			
            <form name="contact" action="" method="post" >

                <label for="fname">First Name&nbsp&nbsp</label>
                <input type="text" id="fname" name="firstname" placeholder="Your name..">
                <br>
                <label for="lname">Last Name&nbsp&nbsp</label>
                <input type="text" id="lname" name="lastname" placeholder="Your last name..">
                <br>
                <label for="region">Region&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                <select id="region" name="region">
                <option value="africa">Africa</option>
                <option value="apac">Asia Pacific</option>
                <option selected="selected" value="europe">Europe</option>
                <option value="the_americas">The Americas</option>
                </select>
                <br>
                <label for="subject">Subject</label>
                <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px; width:400px;"></textarea>
                <div class="col1">
                    <input type="submit" value="Submit" name="submit">
                </div>

            </form>
            <?php
                if($output != "") {
                    echo "<center>";
                    print "$output";
                    echo "</center>";
                }
            ?>
			</div>
			<div class="col-sm-4">
			</div>
		</div>	
	</div>
	<?php 
    include 'footer.php';
    ?>
</body>
</html>