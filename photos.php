<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Photos</title>
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
   

    <h2>You are currently looking at all of the photos!</h2>

    <?php
    require_once 'includes/config.php';
    $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ( $mysqli->connect_errno ) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }

    $result = $mysqli->query("SELECT * FROM photos");

    while($row = $result->fetch_assoc()){
        echo "<div class='entry'><div class='thumb'>";
        echo '<a href="indivPhoto.php?id='.$row['photoID'].'"><h4>'. $row['ptitle']."</h4></a>";
        echo "<img src=images/".$row['fileName']." alt='".$row['ptitle']."'>"; 
        echo "<p class='captions'>by ".$row['credit']."</p>";
        echo "</div></div>";

    }
    ?>
 
</div> 

</body>

</html>