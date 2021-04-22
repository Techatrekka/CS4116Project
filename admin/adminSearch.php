<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../display_user.php';
include '../vacancies/display_vacancy.php';
include '../companies/display_company.php';
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
    } else if ($radio == "companies") {
        $button_input = "companies";
    } else if ($radio == "vacancies") {
        $button_input = "vacancies";
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

    <title>Admin - Search</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Administrator Options</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" >
                <h3>Control Content and Users</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit. Vivamus in lacus vulputate, consectetur lorem vitae, rhoncus massa. Aenean sit amet mi at tortor aliquet gravida. Integer ornare justo sapien, non finibus nisl lacinia sit amet. Proin aliquam id nibh ac vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                    <li><a href="admin_page.php">All Users</a></li>
                    <li><a href="adminCompanies.php">All Companies</a></li>
                    <li><a href="adminVacancies.php">All Vacancies</a></li>
                    <li><a href="adminBanned.php">Banned Users</a></li>
                    <li><strong><a href="adminSearch.php" style="color:#f3b400;">Search</a></strong></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3>Search for Users, Companies or Vacancies</h3>
                <p>
                <form name="search" action="" method="get" >
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit" name="submit" ><img src="../images/search.png" width="30" height="20"></button>
                    <br>
                    <input type="radio" id="users" name="search_type" value="users" <?php if($button_input == "" or $button_input == "users") { print "checked"; } ?>>
                    <label for="users">Users</label>
                    <input type="radio" id="companies" name="search_type" value="companies" <?php if($button_input == "companies") { print "checked"; } ?>>
                    <label for="companies">Companies</label>
                    <input type="radio" id="vacancies" name="search_type" value="vacancies" <?php if($button_input == "vacancies") { print "checked"; } ?>>
                    <label for="vacancies">Vacancies (by title)</label>
                </form>
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
                    } else if($button_input == "companies") {
                        $getCompanies = "select * from companies where name LIKE '%".$input."%';";
                        $companyResults = $conn->query($getCompanies);
                        
                        if(mysqli_num_rows($companyResults)==0) {
                            print "No companies found matching given input";
                        } else {
                            print "Search term matched from companies: $input<br><br>";
                            getCompanyDetails($companyResults);
                        }
                    } else if($button_input == "vacancies") {
                        $getVacancies = "select * from vacancies where vTitle LIKE '%".$input."%';";
                        $vacancyResults = $conn->query($getVacancies);
                        
                        if(mysqli_num_rows($vacancyResults)==0) {
                            print "No vacancies found matching given input";
                        } else {
                            print "Search term matched from vacancies: $input<br><br>";
                            getVacancyDetails($vacancyResults);
                        }
                    }
                ?>
                </table>
                </p>
            </div>
        </div>
    </div>
     <?php 
    include '../nav_bar/footer.php';
    ?>
</body>
</html>                  