<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include 'display_vacancy.php';
require '../validUser.php';
require 'valid_company_user.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
    <style>
    /* Set a style for the submit button */
	.submit_button {
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

    <title>Create New Company</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Manage Companies</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" >
                <h3>Make and Modify Companies</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit. Vivamus in lacus vulputate, consectetur lorem vitae, rhoncus massa. Aenean sit amet mi at tortor aliquet gravida. Integer ornare justo sapien, non finibus nisl lacinia sit amet. Proin aliquam id nibh ac vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                    <li><a href="companies_all.php">All Companies</a></li>
                    <li><strong><a href="companies.php" style="color:#f3b400;">Create New Company</a></strong></li>
                    <li><a href="your_companies.php">Your Companies</a></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3>Create A New Company</h3>
                <p style="color:#f3b400;">
                <?php
                    if(isset($_POST['submit'])) {
                        if(isset($_POST['uid']) and isset($_POST['name']) and isset($_POST['address']) and isset($_POST['address']) and isset($_POST['about'])) {
                            $uid = $_POST['uid'];
                            $name =  $_POST['name'];
                            $address = $_POST['address'];
                            $email1 = $_POST['email'];
                            $description = $_POST['about'];

                            $email = trim(htmlspecialchars($_POST['email']));
                            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

                            if (preg_match("/^[a-z0-9A-Z-'!@.,() ]*$/", $name) and preg_match("/^[a-z0-9A-Z-'., ]*$/", $address) and preg_match("/^[a-z0-9A-Z-',.@#!() ]*$/", $description)
                                and $email == true) {
                                $makeCompany = "INSERT INTO companies(user_id, name, address, email, description) VALUES($uid, \"$name\", \"$address\", \"$email\", \"$description\");";
                                $conn->query($makeCompany);
                                print "Company created successfully! Click Your Companies on the sidebar to see all the companies you own.";
                            } else {
                                if($email != true){
                                    print "Invalid email format - please ensure email address includes @ and .<br>";
                                }
                                if(!preg_match("/^[a-z0-9A-Z-'.!@,() ]*$/", $name)) {
                                    print "Invalid name format - please ensure name only includes upper or lowercase letters, numbers, spaces, or these special characters: .@!,'<br>";
                                }
                                if(!preg_match("/^[a-z0-9A-Z-',. ]*$/", $address)) {
                                    print "Invalid address format - please ensure address only includes upper or lowercase letters, numbers, spaces, or these special characters: ',.<br>";
                                }
                                if(!preg_match("/^[a-z0-9A-Z-'!,#@\.\(\)\[\]\{\}~\$€%&\?\*\^;:\s ]*$/", $description)) {
                                    print "Invalid description format - please ensure description only includes upper or lowercase letters, numbers, spaces, or these special characters: '!,#@.()[]{}~$€%&?*^;:<br>";
                                }
                            }
                        }
                    }
                ?>
                </p>
                <div class = "container" style="padding-top:30px;padding-bottom:150px;">
                    <form name="createCompany" action="" method="post">
                        <h4 class = "form-signin-heading"></h4>
                        <input type = "text" class = "form-control" name ="email" placeholder = "Email" <?php print "value=\"{$email1}\""; ?> required autofocus></br>
                        <input type = "text" class = "form-control" name ="name" placeholder = "Name" <?php print "value=\"{$name}\""; ?> required></br>
                        <input type = "text" class = "form-control" name ="address" placeholder = "Street Address" <?php print "value=\"{$address}\""; ?> required></br>
                        <input type = "text" class = "form-control" name ="about" placeholder = "About" <?php print "value=\"{$description}\""; ?> required></br>
                        <?php
                            $uid = $_SESSION["user_id"];
                            print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                        ?>
                        <button class = "submit_button" type = "submit" name = "submit" style="margin-top:10px;">Create Company</button>
                    </form>
                </div> 
            </div>
        </div>
    </div>
     <?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>