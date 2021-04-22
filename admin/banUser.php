<?php 
session_start();
require '../nav_bar/header.php';
require '../database.php';
include '../display_user.php';
require '../validUser.php';

$url = basename($_SERVER['REQUEST_URI']);
list($page, $uid, $name) = explode("?", $url);

if(isset($_POST['submit'])) {
    $duration = $_POST['duration'];
    $banQuery = "INSERT INTO banned_users(user_id, ban_date, ban_duration) VALUES($uid, CURDATE(), $duration);";
    $conn->query($banQuery);
    $setStatus = "UPDATE users SET ban_status='banned' WHERE user_id=$uid;";
    $statusResult = $conn->query($setStatus);
    $getPermaBanStatus = "select * from banned_users where user_id=$uid;";
    $permaBanResult = $conn->query($getPermaBanStatus);
    if(mysqli_num_rows($permaBanResult) >= 3) {
        $permaBan = "UPDATE users SET ban_status='perma-banned' WHERE user_id=$uid;";
        $conn->query($permaBan);
    }
    header("Location: admin_page.php");
}
if(isset($_POST['cancel'])) {
    header("Location: admin_page.php");
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

    <title>Admin</title>
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
            <div class="col-sm-12 page-sidebar text-center" >
                <h3>How Long Do You Want To Ban This User for?</h3>
                <p>
                <?php
                    print "<strong>ID:</strong> $uid<br>";
                    print "<strong>Name:</strong> $name<br>";
                    print "<form name=\"ban\" action=\"\" method=\"post\" >";
                ?>
                    <label for="duration">Ban Length (days)</label><br>
                    <input type="number" id="duration" name="duration" min="1" required><br>
                    <input type="submit" formnovalidate value="Cancel" name="cancel" style="margin-top:10px">
                    <input type="submit" value="Ban User" name="submit" style="margin-top:10px">
                    </form>
                </p>
            </div>
        </div>
    </div>
     <?php
    include '../nav_bar/footer.php';
    ?>
</body>
</html>