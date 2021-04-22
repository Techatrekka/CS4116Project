<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include 'display_company.php';
require '../validUser.php';
require 'valid_company_user.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">

    <title>Companies - Your Companies</title>
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
            <div class="col-sm-4 page-sidebar" >
                <h3>Make and Modify Companies</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit.
                </p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                    <li><a href="companies_all.php">All Companies</a></li>
                    <li><a href="companies.php">Create New Company</a></li>
                    <li><strong><a href="your_companies.php" style="color:#f3b400;">Your Companies</a></strong></li>
                </ul>
            </div>
            <div class="col-sm-8" style="color:#f1b522;">
                <h3>Your Companies</h3>
                <table>
                <?php 
                   $uid = $_SESSION["user_id"];
                   $getCompanies = "select * from companies where user_id=$uid;";
                   $companiesResult = $conn->query($getCompanies);
                   if(mysqli_num_rows($companiesResult) > 0) {
                        getCompanyDetails($companiesResult);
                   } else {
                       print "You haven't registered any companies yet!";
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