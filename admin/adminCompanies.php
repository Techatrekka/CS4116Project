<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../companies/display_company.php';
require '../validUser.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/style.css">

    <title>Admin - Companies</title>
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
                    <li><strong><a href="adminCompanies.php" style="color:#f3b400;">All Companies</a></strong></li>
                    <li><a href="adminVacancies.php">All Vacancies</a></li>
                    <li><a href="adminBanned.php">Banned Users</a></li>
                    <li><a href="adminSearch.php">Search</a></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3>All Companies</h3>
                <p style="color:#f1b522;">
                 Click on the company's name to be taken to their profile where you can make edits.<br>
                <table>
                <?php 
                    $getCompanies = "select * from companies;";
                    $companiesResult = $conn->query($getCompanies);
                    if(mysqli_num_rows($companiesResult) > 0) {
                        getCompanyDetails($companiesResult);
                    } else {
                        print "There are no companies registered!";
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