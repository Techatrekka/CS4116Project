<?php 
require '../nav_bar/header.php';
require '../database.php';
include '../display_user.php';
require '../validUser.php';

$input = "";
$button_input = "";

if(isset($_GET['submit'])) {
    if(empty($_GET['search'])){
        $input = "Enter a search term";
    } else {
        $input=$_GET['search'];
    }
   $radio = $_GET["search_type"];

    if($radio == "users") {
        $button_input ="users";
    } else if ($radio == "skills") {
        $button_input = "skills";
    } else if ($radio == "company_name") {
        $button_input = "company_name";
    } else if ($radio == "job_position") {
        $button_input = "job_position";
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
    <link rel="stylesheet" href="/styles/style.css">

    <title>Connections Search</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Find Connections</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" >
                <h3>Connecting with Others</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit. Vivamus in lacus vulputate, consectetur lorem vitae, rhoncus massa. Aenean sit amet mi at tortor aliquet gravida. Integer ornare justo sapien, non finibus nisl lacinia sit amet. Proin aliquam id nibh ac vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>I don't care that they stole my idea... <br> I care that they don't have any of their own.</p>
                    </blockquote>
                    <figcaption>- <cite>Nikola Tesla</cite></figcaption>
                </figure>
                <ul>
                    <li><a href="connections_page.php">All Users</a></li>
                    <li><strong><a href="connections_search.php" style="color:#f3b400;">Search</strong></li>
                    <li><a href="connections_myConnections.php">Your Connections</a></li>
                    <li><a href="connections_pendingConnections.php">Pending Connections</a></li>
            </div>
            <div class="col-sm-8">
                 <div class="search-container">
                 <h3>Search for new Connections</h3>
                    <form name="search_connections" action="" method="get" >
                    <input type="text" placeholder="Search.." name="search" >
                    <button type="submit" name="submit" ><img src="../images/search.png" width="30" height="20"></button>
                    <br>
                    <input type="radio" id="users" name="search_type" value="users" <?php if($button_input == "" or $button_input == "users") { print "checked"; } ?>>
                    <label for="users">Users</label>
                    <input type="radio" id="skills" name="search_type" value="skills" <?php if($button_input == "skills") { print "checked"; } ?>>
                    <label for="skills">Skills</label>
                    <input type="radio" id="company_name" name="search_type" value="company_name" <?php if($button_input == "company_name") { print "checked"; } ?>>
                    <label for="company_name">Company Worked For</label>
                    <input type="radio" id="job_position" name="search_type" value="job_position" <?php if($button_input == "job_position") { print "checked"; } ?>>
                    <label for="job_position">Position in Company</label>
                    </form>
                    <p>
                        <table>
                    <?php
                        if($button_input == "users") {
                            $getUsers = "select * from users where full_name LIKE '%".$input."%';";
                            $usersResult = $conn->query($getUsers);
                           if(mysqli_num_rows($usersResult)==0) {
                                print "No users found matching given input";
                            } else {
                                print "Search term matched from users: $input<br><br>";
                                getUserDetails($usersResult);
                                
                           }
                        } else if($button_input == "skills") {
                            $getSkillID = "select skill_id from skills where name LIKE '%".$input."%';";
                            $skillIDResults = $conn->query($getSkillID);
                            
                            if(mysqli_num_rows($skillIDResults)==0) {
                                print "No skills found matching given input";
                            } else {
                               $userIDs = array();
                               while($row = $skillIDResults->fetch_assoc()) {
                                    $getUserID = "select user_id from user_skills where skill_id={$row["skill_id"]};";
                                    $userIDResult = $conn->query($getUserID);
                                    while($row = $userIDResult->fetch_assoc()) {
                                        array_push($userIDs, $row["user_id"]);
                                    }
                                }
                                if(empty($userIDs)) {
                                    print "No users found with that skill";
                                } else {
                                    print "Search term matched from skills: $input<br><br>";
                                    foreach ($userIDs as $value) {
                                        $getUsers = "select * from users where user_id=$value;";
                                        $usersResult = $conn->query($getUsers);
                                        getUserDetails($usersResult);                                        
                                    }
                                }
                           }
                        } else if($button_input == "company_name") {
                            $getCID = "select cid from companies where name LIKE '%".$input."%';";
                            $CIDResults = $conn->query($getCID);
                            
                            if(mysqli_num_rows($CIDResults)==0) {
                                print "No companies found matching given input";
                            } else {
                                $userIDs = array();
                               while($row = $CIDResults->fetch_assoc()) {
                                    $getUserID = "select user_id from job_history where cid={$row["cid"]};";
                                    $userIDResult = $conn->query($getUserID);
                                    while($row = $userIDResult->fetch_assoc()) {
                                        array_push($userIDs, $row["user_id"]);
                                    }
                                }
                                if(empty($userIDs)) {
                                    print "No users found with that job in their work history";
                                } else { 
                                    print "Search term matched from companies: $input<br><br>";
                                    foreach ($userIDs as $value) {
                                        $getUsers = "select * from users where user_id=$value;";
                                        $usersResult = $conn->query($getUsers);
                                        getUserDetails($usersResult);
                                    }
                                }
                           }
                        } else if($button_input == "job_position") {
                            $getUID = "select user_id from job_history where position LIKE '%".$input."%';";
                            $UIDResults = $conn->query($getUID);
                            
                            if(mysqli_num_rows($UIDResults)==0) {
                                print "No job positions found matching given input";
                            } else {
                                print "Search term matched for job position: $input<br><br>";
                                while($row = $UIDResults->fetch_assoc()) {
                                    $getUsers = "select * from users where user_id={$row["user_id"]}";
                                    $usersResult = $conn->query($getUsers);
                                    getUserDetails($usersResult);
                                }
                           }
                        }
                        ?>
                        </table>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>