<?php 
session_start();
include '../nav_bar/header.php';
include '../database.php';
include '../display_user.php';
require '../validUser.php';

$cid = $_GET['cid'];
$name = $_GET['name'];

if(isset($_POST['cancel'])) {
    header("Location: company_profile.php?$cid");
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
            border:none !important;
        }
        .col1{
            padding: 20px;
            float:center;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Edit Company Details</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Your Company</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-12 page-sidebar text-center" >
                <h3>Edit Your Company's Details</h3>
                <p style="color:#f3b400;">
                <table>
                <?php
                if(isset($_POST['change_email'])) {
                    $email = trim(htmlspecialchars($_POST['email']));
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                    if ($email == true) {
                        $updateEmail = "UPDATE companies SET email='$email' WHERE cid=$cid;";
                        $conn->query($updateEmail);
                        print "Your company's email has been updated!";
                    } else {
                        print "Invalid email format - please ensure email address includes @ and .<br>";
                    }
                }
                if(isset($_POST['change_name'])) {
                    if (preg_match("/^[a-z0-9A-Z-'.() ]*$/", $_POST['name'])) {
                        $name = $_POST['name'];
                        $updateName = "UPDATE companies SET name=\"$name\" WHERE cid=$cid;";
                        $conn->query($updateName);
                        print "Your company's name has been updated!";
                    } else {
                        print "Invalid name format - please ensure name only contains upper or lowercase letters, numbers, spaces, or '.<br>";
                    }
                }
                if(isset($_POST['change_address'])) {
                    if (preg_match("/^[a-z0-9A-Z-',. ]*$/", $_POST['address'])) {
                        $address = $_POST['address'];
                        $updateAddress = "UPDATE companies SET address=\"$address\" WHERE cid=$cid;";
                        $conn->query($updateAddress);
                        print "Your company's street address has been updated!";
                    } else {
                        print "Invalid address format - please ensure address only includes upper or lowercase letters, numbers, spaces, or these special characters: ',.<br>";
                    }
                }
                if(isset($_POST['change_desc'])) {
                    if (preg_match("/^[a-z0-9A-Z-'!,#@\.\(\)\[\]\{\}~\$€%&\?\*\^;:\s ]*$/", $_POST['desc'])) {
                        $desc = $_POST['desc'];
                        $updateDesc = "UPDATE companies SET description=\"$desc\" WHERE cid=$cid;";
                        $conn->query($updateDesc);
                        print "Your company's description has been updated!";
                    } else {
                        print "Invalid description format - please ensure description only includes upper or lowercase letters, numbers, spaces, or these special characters: '!,#@.()[]{}~$€%&?*^;:<br>";
                    }
                }

                print "<tr><td></td><td><strong>Company ID:</strong> $cid</td></tr>";

                $getCompany = "select * from companies where cid=$cid";
                $companyResult = $conn->query($getCompany);
                while($row = $companyResult->fetch_assoc()) {
                    $company_name = $row["name"];
                    $address = $row["address"];
                    $email = $row["email"];
                    $desc = $row["description"];
                    $owner_id =  $row["user_id"];
                    if($row["user_id"] != NULL) {
                        $getCreator = "select * from users where user_id={$row["user_id"]};";
                        $creatorResult = $conn->query($getCreator);
                        while($row = $creatorResult->fetch_assoc()) {
                            $owner_name = $row["full_name"];
                        }
                    } else {
                        $owner_id = "Deleted account";
                        $owner_name = "Deleted account";
                    }
                }

                print "<form name=\"edit_email\" action=\"\" method=\"post\">";
                print "<tr><td class=\"col1\"><label for=\"email\">Email</label>";
                print "<td class=\"col1\"><input type=\"text\" id=\"email\" name=\"email\" value=\"$email\" required>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Email\" name=\"change_email\">";
                print "</form></td></td></td></tr>";

                print "<form name=\"edit_name\" action=\"\" method=\"post\" >";
                print "<tr><td class=\"col1\"><label for=\"name\">Name</label>";
                print "<td class=\"col1\"><input type=\"text\" id=\"name\" name=\"name\" value=\"$company_name\" required>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Name\" name=\"change_name\" style=\"margin:10px\">";
                print "</form></td></td></td></tr>";

                print "<form name=\"edit_pass\" action=\"\" method=\"post\" >";
                print "<tr><td class=\"col1\"><label for=\"address\">Street Address</label>";
                print "<td class=\"col1\"><input type=\"text\" id=\"address\" name=\"address\" value=\"$address\" style=\"margin:10px;\" required>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Address\" name=\"change_address\" style=\"margin:10px\">";
                print "</form></td></td></td></tr>";

                print "<form name=\"edit_about\" action=\"\" method=\"post\" >";
                print "<tr><td class=\"col1\"><label for=\"desc\">Company Description</label>";
                print "<td class=\"col1\"><textarea rows=\"5\" cols=\"22\" name=\"desc\" placeholder=\"Describe your company\">$desc</textarea>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Description\" name=\"change_desc\" style=\"margin:10px\">";
                print "</form></td></td></td></tr>";
                
                print "<form action=\"\" method=\"post\"><tr><td colspan=\"3\"><input type=\"submit\" formnovalidate value=\"Cancel\" name=\"cancel\" style=\"margin-top:10px\"></td></tr></form>";
                ?>
                </table>
                </p>
            </div>
        </div>
    </div>
     <?php
    include '../nav_bar/footer.php';
    ?>
</body>
</html>