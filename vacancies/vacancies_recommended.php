<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include 'display_vacancy.php';
require '../validUser.php';
$uid = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">

    <title>Vacancies - Recommended</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Find Vacancies</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" >
                <h3>Searching for Vacancies</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit. Vivamus in lacus vulputate, consectetur lorem vitae, rhoncus massa. Aenean sit amet mi at tortor aliquet gravida. Integer ornare justo sapien, non finibus nisl lacinia sit amet. Proin aliquam id nibh ac vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                   <li><a href="vacancies_page.php">All Vacancies</a></li>
                    <li><a href="vacancies_search.php">Search</a></li>
                    <li><strong><a href="vacancies_recommended.php" style="color:#f3b400;">Recommended for you</a></strong></li>
                </ul>
            </div>
            <div class="col-sm-8"">
                <h3>Vacancies Recommended for You</h3>
                <table>
                <?php 
                    $noneOpen = "false";
                    $getSkillIDs = "select skill_id from user_skills where user_id=$uid";
                    $skillIDsResult = $conn->query($getSkillIDs);
                   
                    if(mysqli_num_rows($skillIDsResult) > 0) {
                        print "You have the following skills which we base these recommendations on: <br>";
                        while($row = $skillIDsResult->fetch_assoc()) {
                            $getSkills = "select * from skills where skill_id={$row['skill_id']}";
                            $skillsResult = $conn->query($getSkills);
                            while($row = $skillsResult->fetch_assoc()) {
                                print "<li><b>{$row['name']}</b></li>";
                            }
                        }
                        print "<br>";
                        
                        $skillIDsResult = $conn->query($getSkillIDs);
                        while($row = $skillIDsResult->fetch_assoc()) {
                            $getVacancyIDs = "select vacancy_id from vacancy_skills where skill_id={$row['skill_id']}";
                            $vacancyIDsResult = $conn->query($getVacancyIDs);
                            if(mysqli_num_rows($vacancyIDsResult) > 0) {
                                while($row = $vacancyIDsResult->fetch_assoc()) {
                                    $getVacancies = "select * from vacancies where vid={$row['vacancy_id']} AND status=1";
                                    $vacanciesResult = $conn->query($getVacancies);
                                    if(mysqli_num_rows($vacanciesResult) > 0) {
                                        getVacancyDetails($vacanciesResult);
                                    } else {
                                        $noneOpen = "Unfortunately, there are no open vacancies matching your skills. Please check back again soon!";
                                    }
                                }
                            } else {
                                $noneOpen = "Unfortunately, there are no open vacancies matching your skills. Please check back again soon!";
                            }
                        }
                        if($noneOpen != "false") {
                            print "$noneOpen";
                        }
                    } else {
                        print "You have no skills! Please add some on your profile and we will recommend suitable vacancies for you.";
                    }
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