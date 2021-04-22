<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../companies/display_company.php';
require '../validUser.php';
include '../display_user.php';
include 'upload_picture.php';

$url = basename($_SERVER['REQUEST_URI']);
list($page, $uid) = explode("?", $url);

$getUser = "select * from users where user_id=$uid";
$userResult = $conn->query($getUser);
while($row = $userResult->fetch_assoc()) {
    $name = $row["full_name"];
    
    if($row['profile_pic'] == null) {
        $pic = "../images/defaultUser.png";
    } else {
        $pic = base64_encode($row['profile_pic']);
    }
    $email = $row["email"];
    $about  = nl2br($row["about"]);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <style>
        label{
            display:inline-block;
        }
        .col1{
            padding: 20px;
            float:center;
        }
        td {
            width: auto !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Profile Page</title>
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
                    $loggedInID = $_SESSION["user_id"];
                    print "<h3>$name</h3>";            
                    $userResult2 = $conn->query($getUser);
                    while($row = $userResult2->fetch_assoc()) {
                        if($row['profile_pic'] == null) {
                            $pic = "";
                            print "<img src=\"../images/defaultUser.png\" width=\"150\" height=\"150\" />";
                        } else {
                            print "<img src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"150\" height=\"150\" />";
                        }
                    }
                    print "<br><br>";
                    
                    if($uid == $loggedInID or $_SESSION["user_type"] == "admin") {
                      uploadPicture("user", $uid);  
                    }
                    print "<br><h5>Email: $email</h5><br>";
                    $getCurrentJob = "select position, cid from job_history where user_id=$uid and (end_date is null or end_date > CURDATE())";
                    $currentJobResult = $conn->query($getCurrentJob);
                    print "<h5>Current Employment: </h5>";
                    if(mysqli_num_rows($currentJobResult) > 0) {
                        while($row = $currentJobResult->fetch_assoc()) {
                            $getCompany = "select name from companies where cid={$row["cid"]}";
                            $companyResult = $conn->query($getCompany);
                            $pos = $row["position"];
                            while($row = $companyResult->fetch_assoc()) {
                                $company = $row["name"];
                            }
                            print "<h5> $pos at $company</h5>";
                        }
                    } else {
                        print "<h5>No job currently</h5>";
                    }
                ?>
                <br><h5>Linked Organisations</h5>
                <ul style="width: 37%; margin: 0 auto;">
                <?php
                    $getOrgs = "select * from companies where user_id=$uid";
                    $orgsResult = $conn->query($getOrgs);
                    if(mysqli_num_rows($orgsResult) > 0) {
                        while($row = $orgsResult->fetch_assoc()) {
                            $cid = $row["cid"];
                            print "<li><a href=\"company_profile.php?$cid\">{$row["name"]}</a></li>";
                        }
                    } else {
                        print "User has no linked organisations.";
                    }
                print "</ul><br><br>";
                
                if($uid == $_SESSION["user_id"] or $_SESSION["user_type"] == "admin") {
                    if($_SESSION["user_type"] == "admin" and $uid != $_SESSION["user_id"]) {
                        print "*To delete users go to the admin tab in the navigation bar. <br>Admin Options:";
                    } else {
                        print "User options:";
                    }
                    print "<li><a href=\"edit_profile.php?uid=$uid&name=$name\">Edit Profile</a></li>";
                    print "<li><a href=\"edit_details.php?uid=$uid&name=$name\">Edit Account Details</a></li>";
                    print "<br><br>";
                }
                if($uid != $_SESSION["user_id"]) {
                    displayButtons($_SESSION["user_id"], $uid);
                }
                 print "<br><br>";
                ?>
            </div>
            <div class="col-sm-8">
                <?php 
                    print "<h3>About</h3>$about";
                    print "<br><br><h3>Qualifications</h3>";

                    $getQualIDs = "select qid, obtained_date from user_qualifications where uid=$uid";
                    $qualIDsResult = $conn->query($getQualIDs);
                    if(mysqli_num_rows($qualIDsResult) > 0) {
                        while($row = $qualIDsResult->fetch_assoc()) {
                            print "<b>Date Obtained:</b> {$row["obtained_date"]}<br>";
                            $getQuals = "select * from qualifications where qualification_id={$row["qid"]}";
                            $qualsResult = $conn->query($getQuals);
                            while($row = $qualsResult->fetch_assoc()) {
                                print "<b>Title:</b> {$row["title"]}<br>";
                                print "<b>Level:</b> {$row["level"]}<br><br>";
                            }
                        }
                    } else {
                        print "This user has no qualifications listed.<br>";
                    }

                    print "<h3>Experience</h3>";
                    $getHistory = "select * from job_history where user_id=$uid;";
                    $historyResult = $conn->query($getHistory);
                    print "<table style=\"width:100%;\">";
                    if(mysqli_num_rows($historyResult) > 0) {
                        while($row = $historyResult->fetch_assoc()) {
                            if($row["cid"] != NULL) {
                                $getCompanyDetails = "select * from companies where cid={$row["cid"]}";
                                $cid = $row["cid"];
                                $companyDetailsResult = $conn->query($getCompanyDetails);
                                while($row1 = $companyDetailsResult->fetch_assoc()) {
                                    if($row1['company_pic'] == null) {
                                        print "<tr><td rowspan=5><img src=\"../images/defaultCompany.jpg\" width=\"100\" height=\"100\"/></td></tr>";
                                    } else {
                                        $company_pic = base64_encode($row1['company_pic']);
                                        print "<tr><td rowspan=5><img src=\"data:image/jpg;charset=utf8;base64, $company_pic \" width=\"100\" height=\"100\" /></td></tr>";
                                    }
                                    print "<tr><td><b>Employer: </b></td> <td><a href=\"company_profile.php?$cid\">{$row1["name"]}</a></td></tr>";
                                }
                            } else {
                                print "<tr><td rowspan=5><img src=\"../images/defaultCompany.jpg\" width=\"100\" height=\"100\"/></td></tr>";
                                print "<tr><td><b>Employer:</b></td> <td> Deleted Company<br></td></tr>";
                            }
                            print "<tr><td><b>Position:</b></td> <td>{$row["position"]}</td></tr>";
                            print "<tr><td><b>Start Date:</b></td> <td>{$row["start_date"]}</td></tr>";
                            if($row["end_date"] != null) {
                                print "<tr><td><b>End Date:</b></td> <td>{$row["end_date"]}</td></tr>";
                            }
                            print "<tr><td></td></tr>";
                        }
                    } else { 
                        print "This user has no previous work history.";
                    }
                    print "</table>";
                    
                    print "<br><h3>Skills</h3>";
                    $getSkillIDs = "select skill_id, date_added from user_skills where user_id=$uid";
                    $skillIDsResult = $conn->query($getSkillIDs);
                    if(mysqli_num_rows($skillIDsResult) > 0) {
                        while($row = $skillIDsResult->fetch_assoc()) {
                            print "<b>Date Added:</b> {$row["date_added"]}<br>";
                            $getSkills = "select * from skills where skill_id={$row["skill_id"]}";
                            $skillsResult = $conn->query($getSkills);
                            while($row = $skillsResult->fetch_assoc()) {
                                print "<b>Skill:</b> {$row["name"]}<br>";
                                print "<b>Level:</b> {$row["level"]}<br>";
                            }
                        }
                    } else {
                        print "This user has no skills listed.<br>";
                    }
                    ?>
            </div>
        </div>
    </div>
     <?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>