<?php
require '../database.php';
 
if(isset($_POST['submit'])) {
    if(isset($_POST['cid'])) {
        $cID = $_POST['cid'];
        $deleteCompany = "DELETE from companies where cid=$cID;";
        $conn->query($deleteCompany);
        $getCompVacancies = "select vid from vacancies where cid=$cID;";
        $vacanciesResult = $conn->query($getCompVacancies);
        while($row = $vacanciesResult->fetch_assoc()) {
            $deleteVacancySkills = "DELETE from vacancy_skills where vacancy_id={$row['vid']};";
            $conn->query($deleteVacancySkills);
        }
        $deleteCompanyVacancies = "DELETE from vacancies where cid=$cID;";
        $conn->query($deleteCompanyVacancies);
        $updateJobHistory = "UPDATE job_history SET cid=NULL where cid=$cID;";
        $conn->query($updateJobHistory);
    }
}

function getCompanyDetails($result) {
   
    global $conn;
    $str = basename($_SERVER['PHP_SELF']);
    $pattern = "/admin/i";
    
    while($row = $result->fetch_assoc()) {
        $cID = $row["cid"];
        $companyName = $row["name"];
        if($row['company_pic'] == null) {
                print "<TR><TD><img class=\"img-fluid\" src=\"../images/defaultCompany.jpg\" width=\"150\" height=\"150\" alt=\"Company Picture\"> </TD>";
            } else {
                $pic = base64_encode($row['company_pic']);
                print "<TR><TD><img class=\"img-fluid\" src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"150\" height=\"150\" alt=\"Company Picture\"> </TD>";
        }
        print "<TD><b>Name: </b><a  href=\"../profile/company_profile.php?$cID\">{$row["name"]}</a><BR>";
        print "<b>Address: </b>{$row["address"]}<br>";
        print "<b>Email: </b>{$row["email"]}<br>";
        print "<b>About: </b>{$row["description"]}<br>";
        print "<b>Owner</b> <br>";
        $uid = $row["user_id"];
        if($row["user_id"] == NULL) {
            print "Deleted User<br>";
        } else {
            print "<i>User ID: </i>{$row["user_id"]}<br><i> Name: </i>";
            $userID = $row["user_id"]; 

            $getCreator = "select * from users where user_id={$row["user_id"]};";
            $creatorResult = $conn->query($getCreator);
            while($row = $creatorResult->fetch_assoc()) {
                print "<a href=\"../profile/profile_page.php?$userID\">{$row["full_name"]}</a><br>";
            }
        }

        $getVacancies = "select vid from vacancies where cid=$cID and status=1;";
        $vacanciesResult = $conn->query($getVacancies);
        $openCount = 0;
        while($row = $vacanciesResult->fetch_assoc()) {
            ++$openCount;
        }
        print "Has $openCount open vacancies listed<br>";

        $getVacancies = "select vid from vacancies where cid=$cID and status=0;";
        $vacanciesResult = $conn->query($getVacancies);
        $closeCount = 0;
        while($row = $vacanciesResult->fetch_assoc()) {
            ++$closeCount;
        }
        print "Has $closeCount closed vacancies listed";
       
        if($_SESSION["user_type"] == "business" and $_SESSION["user_id"] == $uid or $_SESSION["user_type"] == "admin") {
            print "<form name=\"create_vacancy\" action=\"/companies/create_vacancy.php\" method=\"post\" >";
            print "<button type=\"submit\" name=\"submit\" style=\"margin-top:10px;margin-left:5px;margin-right:5px;\">Create new vacancy for this company</button>";
            print "<input type=\"hidden\" id=\"cid\" name=\"cid\" value=\"$cID\">";
            print "<input type=\"hidden\" id=\"name\" name=\"name\" value=\"$companyName\">";
            print "</form>";

            print "<form name=\"remove_company\" action=\"\" method=\"post\" >";
            print "<button type=\"submit\" name=\"submit\" style=\"margin-top:10px;margin-left:5px;margin-right:5px;margin-bottom:5px;\"  onclick=\"return confirm('Do you really want to delete this company?')\">Delete</button></td></tr>";
            print "<input type=\"hidden\" id=\"cid\" name=\"cid\" value=\"$cID\">";
            print "</form>";
        }
    }
}

?>