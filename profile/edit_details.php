<?php 
session_start();
include '../nav_bar/header.php';
include '../database.php';
include '../display_user.php';
require '../validUser.php';

$uid = $_GET['uid'];
$name = $_GET['name'];

if(isset($_POST['cancel'])) {
    header("Location: profile_page.php?$uid");
}
?>
<!DOCTYPE html>
<html lang="en">
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
            border: none !important;
            vertical-align:bottom;
        }
        .col1{
            padding: 10px;
            float:center;
        }
    </style>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Edit Account Details</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Your Account</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-12 page-sidebar text-center" >
                <h3>Edit Your Details</h3>
                <p style="color:#f3b400;">
                <?php
                print "<strong>User ID:</strong> $uid<br>";
                if(isset($_POST['change_email'])) {
                    $email = trim(htmlspecialchars($_POST['email']));
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                    if ($email == true) {
                        $updateEmail = "UPDATE users SET email='$email' WHERE user_id=$uid;";
                        $conn->query($updateEmail);
                        print "Your email has been updated!";
                    } else {
                        print "Invalid email format - please ensure email address includes @ and .<br>";
                    }
                }
                if(isset($_POST['change_name'])) {
                    if (preg_match("/^[a-z0-9A-Z-'. ]*$/", $_POST['name'])) {
                        $name = $_POST['name'];
                         $updateName = "UPDATE users SET full_name=\"$name\" WHERE user_id=$uid;";
                         $conn->query($updateName);
                        print "Your name has been updated!";
                    } else {
                        print "Invalid name format - please ensure name only contains upper or lowercase letters, numbers, spaces, or '.<br>";
                    }
                }
                if(isset($_POST['change_pass'])) {
                    if (preg_match("/^[a-z0-9A-Z-'@,#.!]*$/", $_POST['password'])) {
                        $password = $_POST['password'];
                        $updatePass = "UPDATE users SET password=\"$password\" WHERE user_id=$uid;";
                        $conn->query($updatePass);
                        print "Your password has been updated!";
                    } else {
                        print "Invalid password format - please ensure password only contains upper or lowercase letters, numbers, or these special characters: '@#,.!";
                    }
                }

                $getUser = "select * from users where user_id=$uid";
                $userResult = $conn->query($getUser);
                while($row = $userResult->fetch_assoc()) {
                    $full_name = $row["full_name"];
                    $email = $row["email"];
                }
                print "<table>";
                print "<form name=\"edit_email\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"email\">Email</label></td>";
                print "<td class=\"col1\"><input type=\"text\" id=\"email\" name=\"email\" value=\"$email\" required></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Email\" name=\"change_email\" style=\"margin:10px\">";
                print "</form></td></tr>";
                
                print "<form name=\"edit_name\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"name\">Full Name</label></td>";
                print "<td class=\"col1\"><input type=\"text\" id=\"name\" name=\"name\" value=\"$full_name\" required></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Name\" name=\"change_name\" style=\"margin:10px\">";
                print "</form></td></tr>";

                print "<form name=\"edit_pass\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\"></td>";
                print "<tr><td class=\"col1\"><label for=\"password\">Password</label></td>";
                print "<td class=\"col1\"><input type=\"password\" id=\"password\" name=\"password\" style=\"margin:10px;\" required>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Password\" name=\"change_pass\" style=\"margin:10px\">";
                print "</form></td></tr>";
                
                print "<form action=\"\" method=\"post\"><tr><td colspan=\"3\"><input type=\"submit\" formnovalidate value=\"Cancel\" name=\"cancel\" style=\"margin-top:10px\"></td></tr></form>";
                print "</table>";
                ?>
                </p>
            </div>
        </div>
    </div>
     <?php
    include '../nav_bar/footer.php';
    ?>
</body>
</html>