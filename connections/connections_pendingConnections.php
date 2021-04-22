<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../display_user.php';
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
    <link rel="stylesheet" href="/styles/quote_style.css">

    <title>Pending Connections</title>
  </head>
  <body>
    <div class="container page-heading">
        <div class="row">
            <div class="col-sm-12 page-title-bar">
                <h1>Pending Connections</h1>
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
                        <p>Words can be like X-rays, if you use them properly—they’ll go through anything. You read and you’re pierced.</p>
                    </blockquote>
                    <figcaption>— Aldous Huxley, <cite>Brave New World</cite></figcaption>
                </figure>
                <ul>
                    <li><a href="connections_page.php">All Users</a></li>
                    <li><a href="connections_search.php">Search</a></li>
                    <li><a href="connections_myConnections.php">Your Connections</a></li>
                    <li><strong><a href="connections_pendingConnections.php" style="color:#f3b400;">Pending Connections</a></strong></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3>Requests Received</h3>
                <p style="color:#f1b522;">
                <table>
                <?php 
                $pendingConnections = "SELECT * from connections where second_user=$uid AND status='pending';";
                $getPendingConnections = $conn->query($pendingConnections);
                if(mysqli_num_rows($getPendingConnections) > 0) {
                     while($row = $getPendingConnections->fetch_assoc()) {
                        $userDetails = "SELECT * from users where user_id={$row['first_user']};";
                        $getDetails = $conn->query($userDetails);
                        getUserDetails($getDetails);
                     }
                } else {
                    print "You have no pending connection requests from other users.";
                }
                ?>
                </table>
                </p>
                <h3>Requests Sent</h3>
                <p style="color:#f1b522;">
                <table>
                <?php 
                    $pendingConnections = "SELECT * from connections where first_user=$uid AND status='pending';";
                    $getPendingConnections = $conn->query($pendingConnections);
                    if(mysqli_num_rows($getPendingConnections) > 0) {
                        while($row = $getPendingConnections->fetch_assoc()) {
                            $userDetails = "SELECT * from users where user_id={$row['second_user']};";
                            $getDetails = $conn->query($userDetails);
                            getUserDetails($getDetails);
                        }
                    } else {
                        print "You have no pending connection requests to other users.";
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