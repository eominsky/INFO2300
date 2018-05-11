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

    <h2>You are currently looking at this photo:</h2>

    <?php
    require_once 'includes/config.php';
    $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $photo_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT ); 

    $result = $mysqli->query("SELECT * FROM photos WHERE photoID = '".$photo_id."'");   

    while ($photorow = $result->fetch_assoc()) {
        echo "<div class='entry'>";
        echo "<h2>". $photorow['ptitle']."</h2>";
        echo "<img src=images/".$photorow['fileName']." alt='".$photorow['ptitle']."'>"; 
        echo "<p class='captions'>by ".$photorow['credit']."</p>";
        echo "</div>";

        $albumResult = $mysqli->query("SELECT * FROM albums INNER JOIN tables ON albums.albumID=tables.albumID WHERE tables.photoID='".$photorow['photoID']."'");
        echo "<h2>In albums:</h2>";
        while ($arow = $albumResult->fetch_assoc()) {
            echo '<a href="indivAlbum.php?id='.$arow['albumID'].'"><h3>'. $arow['atitle']."</h3></a>";
        }
    }
    ?>
<a href="photos.php"><h3>go back to all photos</h3></a>

</div> 

</body>

</html>