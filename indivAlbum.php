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

    <h2>You are currently looking at this album:</h2>

    <?php
    require_once 'includes/config.php';
    $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $album_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT ); 

    $result = $mysqli->query("SELECT * FROM albums WHERE albumID = '".$album_id."'");   

    while ($albumrow = $result->fetch_assoc()) {
        echo "<h2>". $albumrow['atitle']."</h2>";
        echo "<p>". $albumrow['description']."</p>";
        $photoResult = $mysqli->query("SELECT * FROM photos INNER JOIN tables ON photos.photoID=tables.photoID WHERE tables.albumID='".$albumrow['albumID']."'");
        while ($photorow = $photoResult->fetch_assoc()) {
            echo "<div class='entry'><div class='thumb'>";
            echo '<a href="indivPhoto.php?id='.$photorow['photoID'].'"><h4>'. $photorow['ptitle']."</h4></a>";
            echo "<img src=images/".$photorow['fileName']." alt='".$photorow['ptitle']."'>"; 
            echo "<p class='captions'>by ".$photorow['credit']."</p>";
            echo "</div></div>";
        }
    }
    ?>
<a href="albums.php"><h3>go back to all albums</h3></a>

</div> 

</body>

</html>