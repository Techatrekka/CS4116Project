<?php 
require './nav_bar/header.php';
require 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/quote_style.css">

    <title>Welcome to Employmee</title>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <div class="container-fluid">
        <div class="row align-items-start">
        <div class="col" style="color:#f1b522;padding-top: 50px;padding-left:30px;padding-right:30px;">
       <!-- <img src="images\leftColimg.png" height="350px" width="350px" style="padding-top: 100px; padding-left:10px;"> -->
        <h3><strong>Grow Your Network</strong></h3>
        <p>Connect with users from all around the world.<br>Find new opportunities and jobs. Build your online presence gain global recognition</p>
        <figure>
                    <blockquote cite="http://amzn.to/2bGtNba">
                        <p>Communication is merely an exchange of information, but connection is an exchange of our humanity.</p>
                    </blockquote>
                    <figcaption>— Sean Stephenson, <cite>Get Off Your “But”</cite></figcaption>
                </figure>
        </div>
        <div class="col">
            <img src="images\centreColImage.png" width="350px" height="350px">		
        </div>
            <div class="col" style="color:MidnightBlue;padding-top: 50px;padding-right:30px;">
                    <h3><b>What is EmployMee?</b></h3>
                    <p><b>EmployMee is a social networking site that allows users to craft 
                    a descriptive professional profile. The site allows you to search for 
                    jobs based on your own skills while simultaneously offering companies
                    a platform to advertise vacancies and search for potential employees 
                    based on their skills and past work experience.</b></p>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color:MidnightBlue;">
        <div class="row align-items-start" style="padding-top:50px;padding-bottom:50px;">
                <div class="col">
                </div>
                <div class="col">
                    <div class="row align-items-center" style="color:White;">
                        <div class="col">
                            <img src="images\midcolleft.png">
                            <h5>Grow Your Network</h5>
                            <p>Connect with other users around the world
                            and have the network you always wanted.</p>
                        </div>
                        <div class="col">
                            <img src="images\midcolcentre.png">
                            <h5>Find New Jobs</h5>
                            <p>Find new job oppurtunities by searching
                            through vacancies and apply for your dream job.</p>
                        </div>
                        <div class="col">
                            <img src="images\midcolright.png">
                            <h5>Portfolio</h5>
                            <p>Create a portfolio for prospective employers to view</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                </div>
        </div>
    </div>
    <?php 
    include './nav_bar/footer.php';
    ?>
  </body>
</html>
