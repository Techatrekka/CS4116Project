<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include 'display_vacancy.php';
include 'display_company.php';
require '../validUser.php';

if(isset($_GET['submit'])) {
    if(empty($_GET['search'])){
        $input = "Enter a search term";
    } else {
        $input=$_GET['search'];
    }
   $radio = $_GET["search_type"];

    if($radio == "name") {
        $button_input ="name";
    } else if ($radio == "desc") {
        $button_input = "desc";
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
    <style>
    /* Set a style for the submit button */
	.submit_button {
	  background-color: #f3b400;
	  color: white;
	  padding: 16px 20px;
	  margin: 20px 0;
	  border: none;
	  cursor: pointer;
	  width: 100%;
	  opacity: 0.9;
	}
	</style>

    <title>All Companies</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>View All Companies</h1>
            </div>
        </div>
    </div>
    <div class="container sidebar">
        <div class="row">
            <div class="col-sm-4 page-sidebar" >
                <h3>Find A Company</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut viverra sem ac dolor accumsan rhoncus ac quis felis. Mauris dui diam, venenatis et metus fringilla, auctor aliquet ex. Integer in ligula vitae arcu maximus egestas. Maecenas massa erat, condimentum dapibus blandit ut, pulvinar sit amet ligula. Sed porta eros sit amet est ornare blandit. Vivamus in lacus vulputate, consectetur lorem vitae, rhoncus massa. Aenean sit amet mi at tortor aliquet gravida. Integer ornare justo sapien, non finibus nisl lacinia sit amet. Proin aliquam id nibh ac vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
                <figure>
                    <blockquote cite="https://www.huxley.net/bnw/four.html">
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                    <li><strong><a href="companies_all.php" style="color:#f3b400;">All Companies</a></strong></li>
                    <?php if($_SESSION["user_type"] == "business" or $_SESSION["user_type"] == "admin") {
                            print "<li><a href=\"companies.php\">Create New Company</a></li>";
                            print "<li><a href=\"your_companies.php\">Your Companies</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3>All Companies</h3>
                <p style="color:#f3b400;">
                 Click on the company's name to be taken to their profile.<br>Search for companies below based on the company name or description.
                 <?php
                    if($_SESSION["user_type"] == "admin") {
                        print "<br><b>As you are an admin, you can create new vacancies for each company and you can delete companies from this page.</b>";
                    }
                ?>
                <table>
                <form name="search_connections" action="" method="get" >
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit" name="submit" style="margin:10px;"><img src="../images/search.png" width="30" height="20"></button>
                    <br>
                    <input type="radio" id="name" name="search_type" value="name" <?php if($button_input == "" or $button_input == "name") { print "checked"; } ?>>
                    <label for="name" style="margin:5px;">Company Name</label>
                    <input type="radio" id="desc" name="search_type" value="desc" <?php if($button_input == "desc") { print "checked"; } ?>>
                    <label for="desc" style="margin:5px;">Company Description</label>
                </form>
                <?php
                if(!isset($_GET['submit'])) {
                    $getCompanies = "select * from companies;";
                    $companiesResult = $conn->query($getCompanies);
                    if(mysqli_num_rows($companiesResult) > 0) {
                        getCompanyDetails($companiesResult);
                    } else {
                        print "There are no companies registered!";
                    }
                } else {
                    if($button_input == "name") {
                        $getCompanies = "select * from companies where name LIKE '%".$input."%';";
                        $companiesResult = $conn->query($getCompanies);
                        if(mysqli_num_rows($companiesResult)==0) {
                            print "<br><br>No companies found matching given input";
                        } else {
                            print "<br><br>Search term matched from companies: $input<br><br>";
                            getCompanyDetails($companiesResult);
                        }                                
                    } else if($button_input == "desc") {
                        $getCompanies = "select * from companies where description LIKE '%".$input."%';";
                        $companiesResult = $conn->query($getCompanies);
                        if(mysqli_num_rows($companiesResult)==0) {
                            print "<br><br>No companies found matching given input";
                        } else {
                            print "<br><br>Search term matched from companies descriptions: $input<br><br>";
                            getCompanyDetails($companiesResult);
                        }    
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