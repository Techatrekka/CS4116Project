<?php
session_start();
require '../database.php';
$uid = $_SESSION["user_id"];
 
if(isset($_GET['submit'])) {
    if(isset($_GET['uid'])) {
        $userID = $_GET['uid'];
        $deleteUser = "DELETE from users where user_id=$userID;";
        $conn->query($deleteUser);
        $deleteUserSkills = "DELETE from user_skills where user_id=$userID;";
        $conn->query($deleteUserSkills);
        $deleteUserQuals = "DELETE from user_qualifications where uid=$userID;";
        $conn->query($deleteUserQuals);
        $deleteBanHistory = "DELETE from banned_users where user_id=$userID;";
        $conn->query($deleteBanHistory);
        $deleteConnections = "DELETE from connections where first_user=$userID or second_user=$userID;";
        $conn->query($deleteConnections);
        $deleteHistory = "DELETE from job_history where user_id=$userID;";
        $conn->query($deleteHistory);
        $updateCompany = "UPDATE companies SET user_id=NULL where user_id=$userID;";
        $conn->query($updateCompany);
    }
}

if(isset($_GET['bansubmit'])) {
    $banString = $_GET['banString'];
    $userID = $_GET['uid'];
    $userName = $_GET['uName'];
    if($banString == 'Ban') {
        header("Location:../admin/banUser.php?$userID?$userName");
    } else if ($banString == 'Undo PermaBan') {
        $banQ = "DELETE from banned_users WHERE user_id=$userID;";
        $updateBan = $conn->query($banQ);
        $setStatus = "UPDATE users SET ban_status='not-banned' WHERE user_id=$userID;";
        $statusResult = $conn->query($setStatus);
    } else {
        $banQ = "UPDATE banned_users SET ban_duration=0 WHERE user_id=$userID and ADDDATE(ban_date, ban_duration ) > DATE(NOW());";
        $updateBan = $conn->query($banQ);
        $setStatus = "UPDATE users SET ban_status='not-banned' WHERE user_id=$userID;";
        $statusResult = $conn->query($setStatus);
    }
}

if(isset($_POST['connect'])) {
    $userID1 = $_POST['uid1'];
    $userID2 = $_POST['uid2'];
    $connectQuery = "INSERT INTO connections(first_user, second_user, creation_date, status) VALUES($userID1, $userID2, CURDATE(), 'pending');";
    $conn->query($connectQuery);
}
if(isset($_POST['disconnect'])) {
    $userID1 = $_POST['uid1'];
    $userID2 = $_POST['uid2'];
    $disconnectQuery = "DELETE FROM connections WHERE first_user=$userID1 AND second_user=$userID2 or first_user=$userID2 AND second_user=$userID1";
    $conn->query($disconnectQuery);
}
if(isset($_POST['pending'])) {
    $userID1 = $_POST['uid1'];
    $userID2 = $_POST['uid2'];
    $disconnectQuery = "DELETE FROM connections WHERE first_user=$userID1 AND second_user=$userID2 or first_user=$userID2 AND second_user=$userID1";
    $conn->query($disconnectQuery);
}

if(isset($_POST['accept'])) {
    $userID1 = $_POST['uid1'];
    $userID2 = $_POST['uid2'];
    $acceptConnection = "UPDATE connections SET status='accepted' WHERE first_user=$userID2 AND second_user=$userID1";
    $conn->query($acceptConnection);
}

if(isset($_POST['reject'])) {
    $userID1 = $_POST['uid1'];
    $userID2 = $_POST['uid2'];
    $rejectConnection = "UPDATE connections SET status='rejected' WHERE first_user=$userID2 AND second_user=$userID1";
    $conn->query($rejectConnection);
}

function getUserDetails($result) {
   
    global $conn;
    $str = basename($_SERVER['PHP_SELF']);
    $pattern = "/admin/i";
    
    $hasJob = false;
    while($row = $result->fetch_assoc()) {
        $banString = "Ban";
        $userID = $row["user_id"]; 

        if($userID != $uid) {
            $name = $row["full_name"];

            $getBanStatus = "select * from banned_users where user_id={$row["user_id"]} and ADDDATE(ban_date, ban_duration ) > DATE(NOW());";
            $banStatusResult = $conn->query($getBanStatus);
            if(mysqli_num_rows($banStatusResult) > 0) {
                $banString = "Un-Ban";
            }

            $getPermaBanStatus = "select * from banned_users where user_id={$row["user_id"]};";
            $permaBanResult = $conn->query($getPermaBanStatus);
            if(mysqli_num_rows($permaBanResult) >= 3) {
                $banString = "Undo PermaBan";
            }
           if($row['profile_pic'] == null) {
                $pic = "/images/defaultUser.png";
                print "<TR><TD><img class=\"img-fluid\" src=\"/images/defaultUser.png\" width=\"150\" height=\"150\" alt=\"Profile Picture\"> </TD>";
            } else {
                $pic = base64_encode($row['profile_pic']);
                print "<TR><TD><img class=\"img-fluid\" src=\"data:image/jpg;charset=utf8;base64, $pic \" width=\"150\" height=\"150\" alt=\"Profile Picture\"> </TD>";
            }
            
            print "<TD><a href=\"../profile/profile_page.php?$userID\">{$row["full_name"]}</a><BR>";
            print "<b>About: </b><br>{$row["about"]}";

            $getCurrentJob = "select position, cid from job_history where user_id={$row["user_id"]} and end_date is null";
            $currentJobResult = $conn->query($getCurrentJob);
            if(mysqli_num_rows($currentJobResult) > 0) {
                while($row = $currentJobResult->fetch_assoc()) {
                    $getCompany = "select name from companies where cid={$row["cid"]}";
                    $companyResult = $conn->query($getCompany);
                    print "<br><b>Position: </b>{$row["position"]}<br>";
                    while($row = $companyResult->fetch_assoc()) {
                        $hasJob = true;
                        print "<b>Company: </b>{$row["name"]}";
                    }
                }
            } else {
                print "<br>No job currently";
            }

            if(preg_match($pattern, $str)) {
                if($banString == "Undo PermaBan")  {
                    print "<strong><br>User is perma-banned.</strong>";
                } else if($banString == "Un-Ban") {
                    while($row = $banStatusResult->fetch_assoc()) {
                        $ban_date = $row["ban_date"];
                        $ban_duration = $row["ban_duration"];
                        print "<strong><br>User is currently banned. <br>Ban Date:</strong> $ban_date<br><strong>Ban Duration:</strong> $ban_duration days";
                    }
                }
                print "</TD><form name=\"ban_user\" action=\"\" method=\"get\" >";
                print "<TD><button type=\"submit\"  name=\"bansubmit\" style=\"margin-top:5px;margin-left:5px;margin-right:5px\">$banString</button>";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$userID\">";
                print "<input type=\"hidden\" id=\"banString\" name=\"banString\" value=\"$banString\">";
                print "<input type=\"hidden\" id=\"uName\" name=\"uName\" value=\"$name\">";
                print "</form>";

                print "<form name=\"remove_user\" action=\"\" method=\"get\" >";
                print "<button type=\"submit\" name=\"submit\" style=\"margin-top:10px;margin-left:5px;margin-right:5px;\"  onclick=\"return confirm('Do you really want to delete this user?')\">Delete</button></td></tr>";
                print "<input type=\"hidden\" id=\"uid\" name=\"uid\" value=\"$userID\">";
                print "</form>";
            } else {
                    if($banString == "Undo PermaBan")  {
                        print "<strong><br>User is perma-banned.</strong>";
                    } else if($banString == "Un-Ban") {
                            print "<strong><br>User is currently banned.</strong>";
                    }
                    displayButtons($_SESSION["user_id"], $userID);
            }
        }
    }
}

function displayButtons($uid, $userID) {
    global $conn;
    $connectionQuery = "SELECT * from connections where first_user=$uid AND second_user=$userID AND status='accepted' or second_user=$uid AND first_user=$userID AND status='accepted';";
    $connectionResult = $conn->query($connectionQuery);
    $connectionQuery2 = "SELECT * from connections where first_user=$uid AND second_user=$userID AND status='pending';";
    $connectionResult2 = $conn->query($connectionQuery2);
    $connectionQuery3 = "SELECT * from connections where second_user=$uid AND first_user=$userID AND status='pending';";
    $connectionResult3 = $conn->query($connectionQuery3);

    $connectionQuery4 = "SELECT * from connections where first_user=$uid AND second_user=$userID AND status='rejected' or second_user=$uid AND first_user=$userID AND status='rejected';";
    $connectionResult4 = $conn->query($connectionQuery4);

    print "<form name=\"connect\" action=\"\" method=\"post\" >";
    print "<input type=\"hidden\" id=\"uid2\" name=\"uid2\" value=\"$userID\">";
    print "<input type=\"hidden\" id=\"uid1\" name=\"uid1\" value=\"$uid\">";
    if(mysqli_num_rows($connectionResult) > 0) {
        print "<TD><button type=\"submit\" name=\"disconnect\" style=\"margin-left:5px;margin-right:5px;\">Disconnect</button></td></tr>";
    } else if(mysqli_num_rows($connectionResult2) > 0) { 
        print "<TD><button type=\"submit\" name=\"pending\" onclick=\"return confirm('Do you really want to cancel this pending connection request?')\">Pending</button></td></tr>";
    } else if(mysqli_num_rows($connectionResult3) > 0) { 
        print "<TD><button type=\"submit\" name=\"accept\" style=\"width:95%;\" onclick=\"return confirm('Do you really want to accept this pending connection request?')\">Accept</button>";
        print "<button type=\"submit\" name=\"reject\" style=\"margin-top:8px;width:95%;\" onclick=\"return confirm('Do you really want to cancel this pending connection request?')\">Reject</button></td></tr>";
    } else if(mysqli_num_rows($connectionResult4) >= 3) {
        print "<TD><button type=\"button\" name=\"rejected\" >Rejected</button></td></tr>";
    } else {                              
        print "<TD><button type=\"submit\" name=\"connect\" >Connect</button></td></tr>";
    }                       
    print "</form>";
}

?>