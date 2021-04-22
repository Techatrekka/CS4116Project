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
            border:none !important;
            // vertical-align:bottom;
        }
        .col1{
            padding: 20px;
            float:center;
        }   
    </style>
    <script>
        function toggleCompanies() {
            var myTable = document.getElementById("companiesTable");
            myTable.style.display = (myTable.style.display == "table") ? "none" : "table";
        }
        function toggleQualifications() {
            var myTable = document.getElementById("qualificationsTab");
            myTable.style.display = (myTable.style.display == "table") ? "none" : "table";
        }
        function toggleSkills() {
            var myTable = document.getElementById("skillsTab");
            myTable.style.display = (myTable.style.display == "table") ? "none" : "table";
        }
    </script>

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
                print "<strong>User ID:</strong> $uid";
                print "<form action=\"\" method=\"post\"><tr><td colspan=\"3\"><input type=\"submit\" formnovalidate value=\"Cancel\" name=\"cancel\" style=\"margin-bottom:15px\"></td></tr></form>";

                if(isset($_POST['edit_desc'])) {
                    if (preg_match("/^[a-z0-9A-Z-'!,#@\.\(\)\[\]\{\}~\$€%&\?\*\^;:\s ]*$/", $_POST['desc'])) {
                        $about = $_POST['desc'];
                        $updateDesc = "UPDATE users SET about=\"$about\" WHERE user_id=$uid;";
                        $conn->query($updateDesc);
                        print "Your about section has been updated!";
                    } else {
                        print "Invalid description format - please ensure description only includes upper or lowercase letters, numbers, spaces, or these special characters: '!,#@.()[]{}~$€%&?*^;:<br>";
                    }
                }
                if(isset($_POST['edit_qual'])) {
                    $currobDate = $_POST['currobDate'];
                    $uq_id = $_POST['uq_id'];
                    if($currobDate > date('Y-m-d')) {
                            print "You can't enter a future obtained date. Please try again.";
                    } else {
                        $updateDate = "UPDATE user_qualifications SET obtained_date=\"$currobDate\" WHERE uqid=$uq_id;";
                        $conn->query($updateDate);
                        print "The obtained date for the qualification has been updated!";
                    }
                }
                if(isset($_POST['delete_qual'])) {
                    $uq_id = $_POST['uq_id'];
                    $deleteQual = "DELETE from user_qualifications WHERE uqid=$uq_id";
                    $conn->query($deleteQual);
                    print "The qualification has been deleted from your profile.";
                }
                if(isset($_POST['edit_work'])) {
                    $startDate = $_POST['startDate'];
                    $endDate = $_POST['endDate'];
                    $pos = $_POST['position'];
                    $jhid = $_POST['JHid'];
                    if($startDate > date('Y-m-d') or ($endDate < $startDate and $end != null)) {
                            print "You can't enter a future start date or an end date which occurs before the start date. Please try again.";
                    } else {
                        $updateJob = "UPDATE job_history SET position=\"$pos\", start_date=\"$startDate\", end_date=\"$endDate\" WHERE JHid=$jhid;";
                        $conn->query($updateJob);
                        print "The job's details have been updated!";
                    }
                }
                if(isset($_POST['delete_work'])) {
                    $jhid = $_POST['JHid'];
                    $deleteJob = "DELETE from job_history WHERE JHid=$jhid;";
                    $conn->query($deleteJob);
                    print "The job has been deleted from your profile.";
                }
                if(isset($_POST['edit_skill'])) {
                    $currobDate = $_POST['currobDate'];
                    $us_id = $_POST['us_id'];
                    if($currobDate > date('Y-m-d')) {
                            print "You can't enter a future obtained date. Please try again.";
                    } else {
                        $updateDate = "UPDATE user_skills SET date_added=\"$currobDate\" WHERE us_id=$us_id;";
                        $conn->query($updateDate);
                        print "The obtained date for the skill has been updated!";
                    }
                }
                if(isset($_POST['delete_skill'])) {
                    $us_id = $_POST['us_id'];
                    $deleteSkill = "DELETE from user_skills WHERE us_id=$us_id";
                    $conn->query($deleteSkill);
                    print "The skill has been deleted from your profile.";
                }
                if(isset($_POST['add_job'])) {
                    $msg = "";
                    if($_POST['company'] == "nocompany") {
                        $name = $_POST['companyName'];
                        if($name == "" ) {
                            $msg = "Please enter a company name or choose one from the list.";
                        } else {
                            $newCompany = "INSERT INTO companies(user_id, name, email) VALUES(NULL, \"$name\", NULL)";
                            $conn->query($newCompany);
                            $cid = $conn->insert_id;
                        }
                    } else {
                        $cid = $_POST['company'];
                        $radioVal = $_POST["company"];
                    }
                    $pos = $_POST['pos'];
                    $startDate = $_POST['startDate'];
                    $endDate = $_POST['endDate'];
                    if($endDate == null) {
                        $addJob = "INSERT into job_history(user_id, cid, start_date, end_date, position) VALUES($uid, $cid, \"$startDate\", NULL, \"$pos\")";
                    } else {
                        if($endDate < $startDate) {
                            $msg = "Please enter an end date which is later than the start date.";
                        } else {
                            $addJob = "INSERT into job_history(user_id, cid, start_date, end_date, position) VALUES($uid, $cid, \"$startDate\", \"$endDate\", \"$pos\")";
                        }
                    }
                    if($msg != "") {
                        print "$msg";
                    } else {
                         $conn->query($addJob);
                         print "Job Added Successfully!";
                    }
                }
                if(isset($_POST['add_qual'])) {
                    $msg = "";
                    if($_POST['qual'] == "noqual") {
                        $title = $_POST['title'];
                        $level = $_POST['level'];
                        
                        if($title == ""  or $level == "") {
                            $msg = "Please enter a qualification name and level or choose a predefined one from the list.";
                        } else {
                            $newQual = "INSERT INTO qualifications(title, level) VALUES(\"$title\", \"$level\")";
                            $conn->query($newQual);
                            $qid = $conn->insert_id;
                        }
                    } else {
                        $qid = $_POST['qual'];
                        $radioVal = $_POST["qual"];
                    }
                    $obDate = $_POST['obDate'];
                    if($obDate > date('Y-m-d')) {
                            $msg = "You can't enter a future obtained date. Please try again.";
                    } else {
                        $addQual = "INSERT into user_qualifications(uid, qid, obtained_date) VALUES($uid, $qid,  \"$obDate\")";
                    }                   
                    
                    if($msg != "") {
                        print "$msg";
                    } else {
                         $conn->query($addQual);
                         print "Qualification Added Successfully!";
                    }
                }
                if(isset($_POST['add_skill'])) {
                    $msg = "";
                    if($_POST['skill'] == "noskill") {
                        $name = $_POST['name'];
                        $level = $_POST['level'];
                        
                        if($name == ""  or $level == "") {
                            $msg = "Please enter a skill name and level or choose a predefined one from the list.";
                        } else {
                            $newSkill = "INSERT INTO skills(name, level) VALUES(\"$name\", \"$level\")";
                            $conn->query($newSkill);
                            $skid = $conn->insert_id;
                        }
                    } else {
                        $skid = $_POST['skill'];
                        $radioVal = $_POST["skill"];
                    }
                    $obDate = $_POST['obDate'];
                    if($obDate > date('Y-m-d')) {
                            $msg = "You can't enter a future obtained date. Please try again.";
                    } else {
                        $addSkill = "INSERT into user_skills(user_id, skill_id, date_added) VALUES($uid, $skid,  \"$obDate\")";
                    }                   
                    
                    if($msg != "") {
                        print "$msg";
                    } else {
                         $conn->query($addSkill);
                         print "Skill Added Successfully!";
                    }
                }


                $getAbout = "select * from users where user_id=$uid";
                $aboutResult = $conn->query($getAbout);
                while($row = $aboutResult->fetch_assoc()) {
                    $curr_desc = $row["about"];
                }

                print "<table>";
                print "<h6><b>Edit About</b></h6>";
                print "<form name=\"edit_desc\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"about\">About:</label></td>";
                print "<td class=\"col1\"><textarea rows=\"5\" cols=\"22\" name=\"desc\" placeholder=\"Describe yourself\">$curr_desc</textarea></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Change Description\" name=\"edit_desc\" style=\"margin:10px\"></td>";
                print "</form></tr>";
                
                print "</table>";

                print "<table>";
                print "<h6><b>Edit Qualifications</b></h6>";
                print "<form name=\"edit_quals\" action=\"\" method=\"post\" >";
                $getUserQuals = "select * from user_qualifications where uid=$uid";
                $userQualsResult = $conn->query($getUserQuals);
                if(mysqli_num_rows($userQualsResult) > 0) {
                    while($row = $userQualsResult->fetch_assoc()) {
                        print "<tr>";
                        $uq_id = $row["uqid"];
                        $q_id = $row["qid"];
                        print "<input type=\"hidden\" id=\"uq_id\" name=\"uq_id\" value=\"$uq_id\">";
                        $getQuals = "select * from qualifications where qualification_id=$q_id";
                        $currobDate= $row["obtained_date"];
                        $quals_result = $conn->query($getQuals);
                        while($row = $quals_result->fetch_assoc()) {
                            print "<td class=\"col1\">{$row["title"]} : Level {$row["level"]}</td>";
                            print "<td class=\"col1\"><label for=\"currobDate\">Obtained Date</label><input type=\"date\" id=\"currobDate\" name=\"currobDate\" value=\"$currobDate\" required></td>";
                            print "<td class=\"col1\"><input type=\"submit\" value=\"Update Qualification\" name=\"edit_qual\" style=\"margin:10px\"></td>";
                            print "<td class=\"col1\"><input type=\"submit\" value=\"Delete Qualification\" name=\"delete_qual\" style=\"margin:10px\"></td>";
                        }
                        print "</tr>";
                    }
                } else {
                    print "You have no qualifications to edit.";
                }
                print "</form>";
                print "</table>";

                print "<table>";
                print "<br><h6><b>Edit Work Experience</b></h6>";
                print "<form name=\"edit_work\" action=\"\" method=\"post\" >";
                $getUserJobs = "select * from job_history where user_id=$uid";
                $userJobsResult = $conn->query($getUserJobs);

                if(mysqli_num_rows($userJobsResult) > 0) {
                    while($row = $userJobsResult->fetch_assoc()) {
                        $jh_id = $row["JHid"];
                        print "<input type=\"hidden\" id=\"JHid\" name=\"JHid\" value=\"$jh_id\">";
                        print "<tr>";
                        $position = $row["position"];
                        $startDate = $row["start_date"];
                        $endDate = $row["end_date"];
                        if($row["cid"] != NULL) {
                            $getCompanyDetails = "select * from companies where cid={$row["cid"]}";
                            $cid = $row["cid"];
                            $companyDetailsResult = $conn->query($getCompanyDetails);
                            while($row = $companyDetailsResult->fetch_assoc()) {
                                print "<td><b>Employer </b><a href=\"company_profile.php?$cid\">{$row["name"]}</a></td>";
                            }
                        } else {
                            print "<td><b>Employer</b> Deleted Company</td>";
                        }
                        
                        print "<td class=\"col1\"><label for=\"position\">Position</label>";
                        print "<input type=\"text\" id=\"position\" name=\"position\" value=\"$position\"></td>";  
                        print "<td class=\"col1\"><label for=\"startDate\">Start Date</label><input type=\"date\" id=\"startDate\" name=\"startDate\" value=\"$startDate\"></td>";
                        print "<td class=\"col1\"><label for=\"endDate\">End Date</label><input type=\"date\" id=\"endDate\" name=\"endDate\" value=\"$endDate\" ></td>";
                        print "<td class=\"col1\"><input type=\"submit\" value=\"Update Job\" name=\"edit_work\" style=\"margin:10px\"></td>";
                        print "<td class=\"col1\"><input type=\"submit\" value=\"Delete Job\" name=\"delete_work\" style=\"margin:10px\"></td></tr>";
                    }
                } else { 
                    print "You have no previous work history.";
                }          
                print "</form>";      
                print "</table>";
                
                print "<table>";
                print "<h6><b>Edit Skills</b></h6>";
                print "<form name=\"edit_skills\" action=\"\" method=\"post\" >";
                $getUserSkills = "select * from user_skills where user_id=$uid";
                $userSkillsResult = $conn->query($getUserSkills);

                if(mysqli_num_rows($userSkillsResult) > 0) {
                    while($row = $userSkillsResult->fetch_assoc()) {
                        print "<tr>";
                        $sk_id = $row["skill_id"];
                        $us_id = $row["us_id"];
                        print "<input type=\"hidden\" id=\"us_id\" name=\"us_id\" value=\"$us_id\">";
                        $getSkill = "select * from skills where skill_id=$sk_id";
                        $currobDate= $row["date_added"];
                        $skills_result = $conn->query($getSkill);
                        while($row = $skills_result->fetch_assoc()) {
                            print "<td class=\"col1\">{$row["name"]} Level: {$row["level"]} </td>";
                            print "<td class=\"col1\"><label for=\"currobDate\">Obtained Date</label><input type=\"date\" id=\"currobDate\" name=\"currobDate\" value=\"$currobDate\" style=\"margin:10px\" required></td>";
                            print "<td class=\"col1\"><input type=\"submit\" value=\"Update Skill\" name=\"edit_skill\" style=\"margin:10px\"></td>";
                            print "<td class=\"col1\"><input type=\"submit\" value=\"Delete Skill\" name=\"delete_skill\" style=\"margin:10px\"></td>";
                        }
                        print "</tr>";
                    }
                } else {
                    print "You have no skills to edit.";
                }
                print "</form>";
                print "</table>";

                print "<table>";
                print "<br><h6><b>Add Qualifications</b></h6>";
                print "<form name=\"add_qualification\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"title\">Title*</label>";
                print "<input type=\"text\" id=\"title\" name=\"title\"></td>";                
                print "<td class=\"col1\"><label for=\"level\">Level</label>";
                print "<input type=\"number\" min=\"1\" id=\"level\" name=\"level\"></td>";
                print "<td class=\"col1\"><label for=\"obDate\">Obtained Date</label><input type=\"date\" id=\"obDate\" name=\"obDate\" required></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Add Qualification\" name=\"add_qual\" style=\"margin:10px\"></td>";

                print "</tr></table>";
                print "*Pick the qualification from the list below if it exists on our website. Otherwise, manually type in the qualification name above!<br>";
                
                print "<table>";
                print "<a id=\"toggleTableDisplay\" onclick=\"toggleQualifications();\" style=\"color:#33BEFF\" >Show/Hide Qualifications</a>";
                $getQualifications = "select * from qualifications;";
                $qualifications = $conn->query($getQualifications);
                print "<table id=\"qualificationsTab\" style=\"display: none\"><tr><form method=\"post\" action=\"\" >";
                print "</tr><tr><td><input type=\"radio\" id=\"noqual\" name=\"qual\" value=\"noqual\" checked><label for=\"qual\">Enter Qualification Manually Above Instead</label></td>";
                if(mysqli_num_rows($qualifications) > 0) {
                    $count = 1;
                    while($row = $qualifications->fetch_assoc()) {
                         $qid = $row["qualification_id"];
                         $count++;
                        if($count > 1 ) {
                            $count = 0;
                            print "</tr><tr><td><input type=\"radio\" id=\"$qid\" name=\"qual\" value=\"$qid\">
<label for=\"qual\">{$row["title"]} Level {$row["level"]}</label></td>";
                        } else {
                            print "<td><input type=\"radio\" id=\"$qid\" name=\"qual\" value=\"$qid\">
<label for=\"qual\">{$row["title"]} Level {$row["level"]}</label></td>";
                        }
                    }
                    
                }
                print "</table>";
                print "</form>"; 
                print "<br>";

                print "<form name=\"current_job\" action=\"\" method=\"post\" >";
                print "<table>";
                print "<h6><b>Add Work Experience</b></h6>";
                print "You can leave the end date blank if this is your current job.";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"position\">Position</label>";
                print "<input type=\"text\" id=\"pos\" name=\"pos\" required></td>";
                print "<td class=\"col1\"><label for=\"company\">Company*</label>";
                print "<input type=\"text\" id=\"companyName\" name=\"companyName\"></td>";
                
                print "<td class=\"col1\"><label for=\"start\">Start Date</label><input type=\"date\" id=\"startDate\" name=\"startDate\" required></td>";
                print "<td class=\"col1\"><label for=\"end\">End Date</label><input type=\"date\" id=\"endDate\" name=\"endDate\"></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Add Job\" name=\"add_job\" style=\"margin:10px\"></td>";
                print "</tr></table>";
                print "*Pick the company from the list below if it exists on our website. Otherwise, manually type in the company name above!<br>";
                
                print "<table>";
                print "<a id=\"toggleTableDisplay\" onclick=\"toggleCompanies();\"style=\"color:#33BEFF\">Show/Hide Companies</a>";
                $getCompanies = "select * from companies;";
                $companiesResult = $conn->query($getCompanies);
                print "<table id=\"companiesTable\" style=\"display: none\"><tr><form method=\"post\" action=\"\" >";
                print "</tr><tr><td><input type=\"radio\" id=\"nocompany\" name=\"company\" value=\"nocompany\" checked><label for=\"company\">Enter Company Manually Above Instead</label></td>";
                if(mysqli_num_rows($companiesResult) > 0) {
                    $count = 1;
                    while($row = $companiesResult->fetch_assoc()) {
                         $cid = $row["cid"];
                         $count++;
                        if($count > 1 ) {
                            $count = 0;
                            print "</tr><tr><td><input type=\"radio\" id=\"$cid\" name=\"company\" value=\"$cid\">
<label for=\"company\">{$row["name"]}</label></td>";
                        } else {
                            print "<td><input type=\"radio\" id=\"$cid\" name=\"company\" value=\"$cid\">
<label for=\"company\">{$row["name"]}</label></td>";
                        }
                    }
                    
                }
                print "</tr></table>";  
                print "</form>";      

                print "<table>";
                print "<br><h6><b>Add Skills</b></h6>";
                print "<form name=\"add_skills\" action=\"\" method=\"post\" >";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$uid\">";
                print "<tr><td class=\"col1\"><label for=\"name\">Name*</label>";
                print "<input type=\"text\" id=\"name\" name=\"name\"></td>";                
                print "<td class=\"col1\"><label for=\"level\">Level</label>";
                print "<input type=\"text\" id=\"level\" name=\"level\"></td>";
                print "<td class=\"col1\"><label for=\"obDate\">Obtained Date</label><input type=\"date\" id=\"obDate\" name=\"obDate\" required></td>";
                print "<td class=\"col1\"><input type=\"submit\" value=\"Add Skill\" name=\"add_skill\" style=\"margin:10px\"></td>";

                print "</tr></table>";
                print "*Pick the skill from the list below if it exists on our website. Otherwise, manually type in the skill name above!<br>";
                
                print "<table>";
                print "<a id=\"toggleTableDisplay\" onclick=\"toggleSkills();\" style=\"color:#33BEFF\">Show/Hide Skills</a>";
                $getSkills = "select * from skills;";
                $skills = $conn->query($getSkills);
                print "<table id=\"skillsTab\" style=\"display: none\"><tr><form method=\"post\" action=\"\" >";
                print "</tr><tr><td><input type=\"radio\" id=\"noskill\" name=\"skill\" value=\"noskill\" checked><label for=\"noskill\">Enter Skill Manually Above Instead</label></td>";
                if(mysqli_num_rows($skills) > 0) {
                    $count = 1;
                    while($row = $skills->fetch_assoc()) {
                         $skid = $row["skill_id"];
                         $count++;
                        if($count > 1 ) {
                            $count = 0;
                            print "</tr><tr><td><input type=\"radio\" id=\"$skid\" name=\"skill\" value=\"$skid\">
<label for=\"skill\">{$row["name"]} - Level: {$row["level"]}</label></td>";
                        } else {
                            print "<td><input type=\"radio\" id=\"$skid\" name=\"skill\" value=\"$skid\">
<label for=\"skill\">{$row["name"]} - Level: {$row["level"]}</label></td>";
                        }
                    }
                }
                print "</table>";
                print "</form>";        
               
                print "<form action=\"\" method=\"post\"><tr><td colspan=\"3\"><input type=\"submit\" formnovalidate value=\"Cancel\" name=\"cancel\" style=\"margin-top:10px\"></td></tr></form>";
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