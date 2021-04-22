<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
    <div class="container-fluid">
    <div class="row align-items-start">
        <div class="col">
            <nav class="navbar navbar-expand-sm navbar-light justify-content-end">
            <div class="container-fluid">
                <div class="col-sm-4">
                    <a href="/index.php"><img src="/images/EmployMeeLogo2.png" class="img-thumbnail" alt="Logo" width="150" height="150">
                        
                    </a>
                </div>
                <div class="col-sm-8">
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                        <?php
                             if($_SESSION['valid'] != true) {
                                print "<a class=\"nav-link\" href=\"/index.php\">Home</a>";
                            } else {
                                $uid = $_SESSION["user_id"];
                                print "<a class=\"nav-link\" href=\"../profile/profile_page.php?$uid\">Home</a>";
                            }
                        ?>
                            <a class="nav-link" href="/nav_bar/about.php">About</a>
                            <a class="nav-link" href="/nav_bar/choose_us.php">Why Choose Us?</a>
                        </div>
                        <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
                            <ul class="navbar-nav text-right">
                                <?php
                                if($_SESSION['valid'] != true) {
                                    print "<a class=\"nav-link\" href=\"/login_reg/login.php\">Login/Signup</a>";
                                } else {
                                    print "<a class=\"nav-link\" href=\"/connections/connections_page.php\">Connections</a>";
                                    print "<a class=\"nav-link\" href=\"/vacancies/vacancies_page.php\">Vacancies</a>";
                                    print "<a class=\"nav-link\" href=\"/companies/companies_all.php\">Companies</a>";
                                    if($_SESSION["user_type"] == "admin") {
                                        print "<a class=\"nav-link\" href=\"/admin/admin_page.php\">Admin</a>";
                                    }
                                    print "<a class=\"nav-link\" href=\"/login_reg/logout.php\">Logout</a>";
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            </nav>
        </div>
    </div>
    </div>
    </body>
</html>
