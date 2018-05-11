<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Albums</title>
</head>

<body>
    <?php
    if ( isset($_SESSION['logged_user_by_sql'] ) ) {
                include 'includes/adminTop.php';
        }else{
            include 'includes/top.php';
        }
    ?>

<div id="content">

    <h2>You are currently looking at all of the albums</h2>

    <?php
    require_once 'includes/config.php';
    $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

       $result = $mysqli->query("SELECT * FROM albums");      
    while ($albumrow = $result->fetch_assoc()) {
        echo '<a href="indivAlbum.php?id='.$albumrow['albumID'].'"><h3>'. $albumrow['atitle']."</h3></a>";
        echo "<p>". $albumrow['description']."</p>";
    }
    ?>

</div> 

</body>

</html>