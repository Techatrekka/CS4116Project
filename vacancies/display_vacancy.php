<?php
require '../database.php';

if(isset($_POST['submit'])) {
    if(isset($_POST['vid'])) {
        $vID = $_POST['vid'];
        $deleteVacancy = "DELETE from vacancies where vid=$vID;";
        $result = $conn->query($deleteVacancy);
        $deleteVacancySkills = "DELETE from vacancy_skills where vacancy_id=$vID;";
        $conn->query($deleteVacancySkills);
    }
}

function getVacancyDetails($result) {
   
    global $conn;
    $url = basename($_SERVER['PHP_SELF']);
    $onAdminPage = "/admin/i";
    $onProfilePage = "/profile/i";
 
    while($row = $result->fetch_assoc()) {
        $vacancyID = $row["vid"];
        $cid = $row["cid"];
        
        print "<tr><td>Title: </td>";
        print "<td>{$row["vTitle"]}</td>";

        if(!(preg_match($onProfilePage, $url))) {
            $getCompany = "select name, company_pic,email, user_id from companies where cid={$row["cid"]}";
            $companyResult = $conn->query($getCompany);

            $getSkills = "select skill_id from vacancy_skills where vacancy_id={$row["vid"]}";
            $skillsResult = $conn->query($getSkills);
            $updated_rowspan = mysqli_num_rows($skillsResult) + 5;

            if(mysqli_num_rows($skillsResult) == 0){
                while($row1 = $companyResult->fetch_assoc()) {
                    print "<td rowspan=6><a href=\"../profile/company_profile.php?$cid\">{$row1["name"]}</a>";
                     if($row1['company_pic'] == null) {
                        print "<img class=\"img-fluid\" src=\"../images/defaultCompany.jpg\" width=\"200px\" height=\"400px\" alt=\"Company Picture\"></td></tr>";
                    } else {
                        $pic = base64_encode($row1['company_pic']);
                        print "<img class=\"img-fluid\" src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"200px\" height=\"400px\" alt=\"Company Picture\"></td></tr>";
                    }
                    $email = $row1["email"];
                    $uid = $row1["user_id"];
                }
            } else{
                while($row1 = $companyResult->fetch_assoc()) {
                    print "<td rowspan={$updated_rowspan}><a href=\"../profile/company_profile.php?$cid\">{$row1["name"]}</a>";
                    if($row1['company_pic'] == null) {
                        print "<img class=\"img-fluid\" src=\"../images/defaultCompany.jpg\" width=\"200px\" height=\"400px\" alt=\"Company Picture\"></td></tr>";
                    } else {
                        $pic = base64_encode($row1['company_pic']);
                        print "<img class=\"img-fluid\" src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"200px\" height=\"400px\" alt=\"Company Picture\"></td></tr>";
                    }
                    $email = $row1["email"];
                    $uid = $row1["user_id"];
                }
            }   
        } else {
            $getUser = "select user_id from companies where cid={$row["cid"]}";
            $companyResult = $conn->query($getUser);
             while($row1 = $companyResult->fetch_assoc()) {
                $uid = $row1["user_id"];
             }
        }

        print "<tr><td>Status: </td>";
        if($row["status"] == true) {
            print "<td>Open</td></tr>";
        } else {
            print "<td>Closed</td></tr>";
        }

        print "<tr><td>Apply by date: </td>";
        print "<td>{$row["apply_by_date"]}</td></tr>";

        print "<tr><td>Description: </td>";
        print "<td>{$row["vDescription"]}</td></tr>";

        print "<tr><td>Required experience: </td>";
        $exp =  nl2br($row["required_experience"]);
        print "<td>{$exp}</td></tr>";
        
        $getSkills = "select skill_id from vacancy_skills where vacancy_id={$row["vid"]}";
        $skillsResult = $conn->query($getSkills);
        if(mysqli_num_rows($skillsResult)==0) {
            print "<tr><td>Required skills: </td>";
            print "<td>None</td></tr>";
        } else {
            while($row = $skillsResult->fetch_assoc()) {
                $getSkillNames = "select name from skills where skill_id={$row["skill_id"]}";
                $skillNameResult = $conn->query($getSkillNames);
                while($row = $skillNameResult->fetch_assoc()) {
                    print "<tr><td>Required skills: </td>";
                    print "<td>{$row["name"]}</td></tr>";
                }
            }
        }
        print "<tr><td colspan=3>Email $email with your CV in order to apply!</td></tr>";
        if(preg_match($onAdminPage, $url)) {
            $removeString = "Remove abusive/offency ad";
            $owner ="";
        } else {
            $owner = "You own the company that made this ad. ";
            $removeString = "Remove vacancy";
        }
        if(preg_match($onAdminPage, $url) or $uid == $_SESSION["user_id"]) {
            print "<form name=\"remove_ad\" action=\"\" method=\"post\" >";
            print "<tr><td colspan=3>$owner<button type=\"submit\" name=\"submit\" style=\"font-size: 16px;margin-top:5px;margin-bottom:5px;\"  onclick=\"return confirm('Do you really want to delete this vacancy?')\">$removeString</button></td></tr>";
            print "<input type=\"hidden\" id=\"vid\" name=\"vid\" value=\"$vacancyID\">";
            print "</form>";
        }
        print "<tr class=blank_row border=dotted><td colspan=3></td></tr>";         
    }
}

function updateVacancyStatus($vacanciesResult) {
    global $conn;
    while($row = $vacanciesResult->fetch_assoc()) {
        $vacancyID = $row["vid"];
        if(date('Y-m-d') > $row["apply_by_date"]) {
            $updateStatus = "UPDATE vacancies SET status=0 WHERE vid=$vacancyID;";
            $conn->query($updateStatus);
        } else {
            $updateStatus = "UPDATE vacancies SET status=1 WHERE vid=$vacancyID;";
            $conn->query($updateStatus);
        }
    }
}
?>