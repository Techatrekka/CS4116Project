<?php 
require '../nav_bar/header.php';
require '../database.php';
include 'display_vacancy.php';
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

    if ($radio == "skills") {
        $button_input = "skills";
    } else if ($radio == "company_name") {
        $button_input = "company_name";
    } else if ($radio == "vacancy_exp") {
        $button_input = "vacancy_exp";
    } else if ($radio == "vacancy_desc") {
        $button_input = "vacancy_desc";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">

    <title>Vacancies - Search</title>
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
                    <li><strong><a href="vacancies_search.php" style="color:#f3b400;">Search</a></strong></li>
                    <li><a href="vacancies_recommended.php">Recommended for you</a></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <div class="search-container">
                    <h3>Search for Vacancies</h3>
                    <form name="search_vacancies" action="" method="get" >
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit" name="submit" ><img src="../images/search.png" width="30" height="20"></button>
                    <br>
                    <input type="radio" id="skills" name="search_type" value="skills" <?php if($button_input == "" or $button_input == "skills") { print "checked"; } ?>>
                    <label for="skills">Skills</label>
                    <input type="radio" id="company_name" name="search_type" value="company_name" <?php if($button_input == "company_name") { print "checked"; } ?>>
                    <label for="company_name">Company</label>
                    <input type="radio" id="vacancy_exp" name="search_type" value="vacancy_exp" <?php if($button_input == "vacancy_exp") { print "checked"; } ?>>
                    <label for="vacancy_exp">Vacancy Experience</label>
                    <input type="radio" id="vacancy_desc" name="search_type" value="vacancy_desc" <?php if($button_input == "vacancy_desc") { print "checked"; } ?>>
                    <label for="vacancy_desc">Vacancy Description</label>
                    </form>

                    <p>
                        <table>
                        <?php
                            if($button_input == "skills") {
                                $getSkillID = "select skill_id from skills where name LIKE '%".$input."%';";
                                $skillIDResults = $conn->query($getSkillID);
                                
                                if(mysqli_num_rows($skillIDResults)==0) {
                                    print "No skills found matching given input";
                                } else {
                                    $vIDs = array();
                                    while($row = $skillIDResults->fetch_assoc()) {
                                        $getVID = "select vacancy_id from vacancy_skills where skill_id={$row["skill_id"]}";
                                        $vIDResult = $conn->query($getVID);
                                        while($row = $vIDResult->fetch_assoc()) {
                                            array_push($vIDs, $row["vacancy_id"]);
                                        }
                                    }
                                    if(empty($vIDs)) {
                                        print "No vacancies found requiring that skill";
                                    } else {
                                        print "Search term matched from skills: $input";
                                        print "<br><br>";
                                        foreach ($vIDs as $value) {
                                            $getVacancies = "select * from vacancies where vid=$value;";
                                            $vacanciesResult = $conn->query($getVacancies);
                                            getVacancyDetails($vacanciesResult);
                                        }
                                    }
                                }
                            } else if($button_input == "company_name") {
                                $getCID = "select cid from companies where name LIKE '%".$input."%';";
                                $CIDResults = $conn->query($getCID);
                                
                                if(mysqli_num_rows($CIDResults)==0) {
                                    print "No companies found matching given input";
                                } else {
                                    $vIDs = array();
                                    while($row = $CIDResults->fetch_assoc()) {
                                        $getVID = "select vid from vacancies where cid={$row["cid"]}";
                                        $vIDResult = $conn->query($getVID);
                                        while($row = $vIDResult->fetch_assoc()) {
                                            array_push($vIDs, $row["vid"]);
                                        }
                                    }
                                   if(empty($vIDs)) {
                                        print "No vacancies found from that company";
                                    } else {
                                        print "Search term matched from companies: $input";
                                        print "<br><br>";
                                        foreach ($vIDs as $value) {
                                            $getVacancies = "select * from vacancies where vid=$value;";
                                            $vacanciesResult = $conn->query($getVacancies);
                                            getVacancyDetails($vacanciesResult);
                                         }
                                    }
                                }
                            } else if($button_input == "vacancy_exp") {
                                $getVacancies = "select * from vacancies where required_experience LIKE '%".$input."%';";
                                $vacanciesResult = $conn->query($getVacancies);
                                if(mysqli_num_rows($vacanciesResult)==0) {
                                    print "No vacancies found matching given experience";
                                } else {
                                    print "Search term matched from vacancies required experience: $input<br><br>";
                                    getVacancyDetails($vacanciesResult);
                                }
                            } else if($button_input == "vacancy_desc") {
                                $getVacancies = "select * from vacancies where vDescription LIKE '%".$input."%';";
                                $vacanciesResult = $conn->query($getVacancies);
                                getVacancyDetails($vacanciesResult);
                                if(mysqli_num_rows($vacanciesResult)==0) {
                                    print "No vacancies found matching given description";
                                } else {
                                    print "Search term matched from vacancies description: $input<br><br>";
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