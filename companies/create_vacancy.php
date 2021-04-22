<?php 
session_start();
include '../nav_bar/header.php';
include '../database.php';
include '../display_user.php';
require '../validUser.php';
require 'valid_company_user.php';

$cid = $_POST['cid'];
$name = $_POST['name'];

if(isset($_POST['cancel'])) {
    header("Location: your_companies.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
        label{
            display:inline-block;
            width:100px;
            margin-right:10px;
            text-align:center;
            }
    </style>
    <script>
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

    <title>Create New Vacancy</title>
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
            <div class="col-sm-12 page-sidebar text-center" >
                <h3>Create New Vacancy</h3>
                <p style="color:#f3b400;">
                <?php
                print "<strong>Company ID:</strong> $cid<br>";
                print "<strong>Company Name:</strong> $name<br>";
                if(isset($_POST['create'])) {
                    $allFieldsGood = true;
                    $manualSkillInput = false;
                    $vTitle =  $_POST['title'];
                    $desc = $_POST['desc'];
                    $exp = $_POST['exp'];
                    $date = $_POST['applyBy'];
                    if($date > date('Y-m-d')) {
                        $status = 1;
                    } else {
                        $status = 0;
                    }

                    if (preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $vTitle) and preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $desc) and preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $exp)) {                        
                        if($_POST['skill_name'] != "" and $_POST['level'] != "") {
                            $skill_name = $_POST['skill_name'];
                            $level = $_POST['level'];
                            $manualSkillInput = true;
                        } else if ($_POST['skill_name'] != "" and !($_POST['level'] != "") or !($_POST['skill_name'] != "") and $_POST['level'] != "") {
                            echo "<b>Please fill in both name and level fields if entering skills manually.<br>";
                            $allFieldsGood = false;
                        }
                        if($allFieldsGood == true) {
                            $qual = $_POST['qual'];
                            if(!empty($qual)) {
                                $exp .= "\n Qualifications: ";
                                $num = count($qual);
                                for($j=0; $j < $num; $j++) {
                                    $exp .= "\n" . $qual[$j];
                                }
                            }  
                            $makeVacancy = "INSERT INTO vacancies(cid, vTitle, vDescription, required_experience, apply_by_date, status) VALUES($cid, \"$vTitle\", \"$desc\", \"$exp\", \"$date\", $status)";
                            
                            $conn->query($makeVacancy);
                            $vid = $conn->insert_id;
                            $skill = $_POST['skill'];
                            if(!empty($skill)) {
                                $N = count($skill);
                                for($i=0; $i < $N; $i++) {
                                    $skill_id = $skill[$i];
                                    $makeVacancySkill = "INSERT INTO vacancy_skills(skill_id, vacancy_id) VALUES($skill_id, $vid);";
                                    $conn->query($makeVacancySkill);
                                }
                            }
                            if($manualSkillInput == true){
                                $newSkill = "INSERT INTO skills(name, level) VALUES(\"$skill_name\", \"$level\")";
                                $conn->query($newSkill);
                                $skill_id = $conn->insert_id;
                                $makeVSkill = "INSERT INTO vacancy_skills(skill_id, vacancy_id) VALUES($skill_id, $vid);";
                                $conn->query($makeVSkill);
                            }
                            header("Location: your_companies.php");
                        }
                    } else {
                        if(!preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $vTitle)) {
                            print "Incorrect title format - please ensure title only includes upper or lowercase letters, numbers, spaces, or these special characters: .@!,'#<br>";
                        }
                        if(!preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $desc)) {
                            print "Incorrect description format - please ensure description only includes upper or lowercase letters, numbers, spaces, or these special characters: .@!,'#<br>";
                        }
                        if(!preg_match("/^[a-z0-9A-Z-',.@#! ]*$/", $exp)) {
                            print "Incorrect experience format - please ensure experience only includes upper or lowercase letters, numbers, spaces, or these special characters: .@!,'#<br>";
                        }
                    }
                }
                    
                    print "<form name=\"new_vacancy\" action=\"\" method=\"post\" >";
                    print "<input type=\"hidden\" id=\"cid\" name=\"cid\" value=\"$cid\">";
                    print "<input type=\"hidden\" id=\"name\" name=\"name\" value=\"$name\">";
                ?>
                    <label for="title">Vacancy Title </label>
                    <input type="text" id="title" name="title" <?php print "value=\"{$vTitle}\""; ?> required><br>
                    <label for="desc">Description </label>
                    <input type="text" id="desc" name="desc" <?php print "value=\"{$desc}\""; ?>required><br>
                    <label for="exp">Experience* </label>
                    <input type="text" id="exp" name="exp" <?php print "value=\"{$exp}\""; ?>><br>
                <?php
                    print "*Enter experience required above. You can also choose a qualification which is required as experience!<br>";
                    
                    print "<table>";
                    print "<a id=\"toggleTableDisplay\" onclick=\"toggleQualifications();\" style=\"color:#33BEFF\">Show/Hide Qualifications</a>";
                    $getQualifications = "select * from qualifications;";
                    $qualifications = $conn->query($getQualifications);
                    print "<table id=\"qualificationsTab\" style=\"display: none\"><tr><form method=\"post\" action=\"\" >";
                    
                    if(mysqli_num_rows($qualifications) > 0) {
                        $count = 1;
                        while($row = $qualifications->fetch_assoc()) {
                            $qid = $row["qualification_id"];
                            $count++;
                            if($count > 1 ) {
                                $count = 0;
                                print "</tr><tr><td><input type=\"checkbox\" id=\"$qid\" name=\"qual[]\" value=\"{$row["title"]} Level {$row["level"]}\">
    <label for=\"qual\">{$row["title"]} Level {$row["level"]}</label></td>";
                            } else {
                                print "<td><input type=\"checkbox\" id=\"$qid\" name=\"qual[]\" value=\"{$row["title"]} Level {$row["level"]}\">
    <label for=\"qual\">{$row["title"]} Level {$row["level"]}</label></td>";
                            }
                        }
                        
                    }
                    print "</table>";  

                    print "<label for=\"skills\">Skills* </label><br>";
                    print "<tr><td class=\"col1\"><label for=\"skill_name\">Name*</label>";
                    print "<input type=\"text\" id=\"skill_name\" name=\"skill_name\"></td>";                
                    print "<td class=\"col1\"><label for=\"level\">Level</label>";
                    print "<input type=\"text\" id=\"level\" name=\"level\"></td>";

                    print "<br>*Pick the skill from the list below if it exists on our website. Otherwise, manually type in a skill name and level above!<br>";
                    
                    print "<table>";
                    print "<a id=\"toggleTableDisplay\" onclick=\"toggleSkills();\" style=\"color:#33BEFF\">Show/Hide Skills</a>";
                    $getSkills = "select * from skills;";
                    $skills = $conn->query($getSkills);
                    print "<table id=\"skillsTab\" style=\"display: none\"><tr><form method=\"post\" action=\"\" >";
                    if(mysqli_num_rows($skills) > 0) {
                        $count = 1;
                        while($row = $skills->fetch_assoc()) {
                            $skid = $row["skill_id"];
                            $count++;
                            if($count > 1 ) {
                                $count = 0;
                                print "</tr><tr><td><input type=\"checkbox\" id=\"$skid\" name=\"skill[]\" value=\"$skid\">
    <label for=\"skill\">{$row["name"]} - Level: {$row["level"]}</label></td>";
                            } else {
                                print "<td><input type=\"checkbox\" id=\"$skid\" name=\"skill[]\" value=\"$skid\">
    <label for=\"skill\">{$row["name"]} - Level: {$row["level"]}</label></td>";
                            }
                        }
                    }
                    print "</table>";
                ?>

                    <label for="applyBy">Apply by date </label>
                    <input type="date" id="applyBy" name="applyBy" <?php print "value=\"{$date}\""; ?>  required><br>
                    
                    <input type="submit" formnovalidate value="Cancel" name="cancel" style="margin-top:10px">
                    <input type="submit" value="Create Vacancy" name="create" style="margin-top:10px">
                    </form>
                </p>
            </div>
        </div>
    </div>
     <?php
    include '../nav_bar/footer.php';
    ?>
</body>
</html>