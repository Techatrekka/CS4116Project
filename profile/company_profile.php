<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../companies/display_company.php';
require '../validUser.php';
include '../vacancies/display_vacancy.php';
include 'upload_picture.php';

$url = basename($_SERVER['REQUEST_URI']);
list($page, $cid) = explode("?", $url);

$getCompany = "select * from companies where cid=$cid";
$companyResult = $conn->query($getCompany);
while($row = $companyResult->fetch_assoc()) {
    $name = $row["name"];
    if($row['company_pic'] == null) {
        $pic = "../images/defaultCompany.jpg";
    } else {
        $pic = base64_encode($row['company_pic']);
    }
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Company Profile Page</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1><?php print "$name"; ?>'s Profile</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" style="width: 50%; margin: 0 auto; text-align: center">
                <?php
                    print "<h3>$name</h3>";             
                    $companyResult2 = $conn->query($getCompany);
                    while($row = $companyResult2->fetch_assoc()) {
                        if($row['company_pic'] == null) {
                            print "<img src=\"../images/defaultCompany.jpg\" width=\"150\" height=\"150\" />";
                        } else {
                            print "<img src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"150\" height=\"150\" />";
                        }
                    }
                    print "<br><br>";
                    if($owner_id == $_SESSION["user_id"] or $_SESSION["user_type"] == "admin") {
                      uploadPicture("company", $cid);  
                    }
                    print "<h3> Contact Us </h3>";
                    print "Our office is at:<BR>" ;
                    print "$address<BR>";
                    print "<BR> Email us at: <BR>";
                    print "$email<BR>";

                if($owner_id == $_SESSION["user_id"] or $_SESSION["user_type"] == "admin") {
                    print "<BR>Company Owner Options:";
                    print "<li><a href=\"edit_company_details.php?cid=$cid&name=$name\">Edit Company Details</a></li>";
                    print "</ul>";
                    print "<br><br>";
                }
                ?>

            </div>
            <div class="col-sm-8">
                <h3>About Us</h3>
                <?php 
                    print "$desc";
                ?>
                <h3>Vacancies</h3>
                <table width=100%>
                <?php 
                $getVacancies = "select * from vacancies where cid=$cid";
                $vacanciesResult = $conn->query($getVacancies);
                updateVacancyStatus($vacanciesResult);
                $vacanciesResult = $conn->query($getVacancies);
                getVacancyDetails($vacanciesResult);
                ?>
                </table>

            </div>
        </div>
    </div>
     <?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>