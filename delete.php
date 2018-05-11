<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Delete</title>
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
    <h2>Delete Album</h2>
    <form method="post" enctype="multipart/form-data">
    <p>Choose Album:</p>
    <?php
        require_once 'includes/config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $result = $mysqli->query("SELECT * FROM albums"); 
        while ($albumrow = $result->fetch_assoc()) {
            echo '<p><input type="checkbox" name="checkedAlbum[]" value="'.$albumrow['albumID'].'">';
            echo $albumrow['atitle'].'</p>';
        }     
    ?>
    <p><input type="submit" name="delete_album_submit"></p>
    </form>


<!-- Delete Album -->
<?php

    if (isset($_POST["delete_album_submit"]) && !empty($_POST["checkedAlbum"])){

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          // Check connection
        if ($mysqli->connect_errno) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $vAlbums = $_POST["checkedAlbum"];
                
            foreach ($vAlbums as $albumID){
                     
                $statement = "DELETE FROM albums
                WHERE albumID= $albumID";
                $result = $mysqli->query($statement);
                echo "<h2>Album deleted!</h2>"; 
                echo "<p> deletion appears upon page refresh</p>";
        }   
               
    }

?>

    <h2>Delete Photo</h2>
    <form method="post" enctype="multipart/form-data">
    <p>Photo Name: <input type="text" name="photoTitle"></p>
    <p><input type="submit" name="delete_photo_submit"></p>
    </form>

<!-- Delete Photo -->
<?php

    if (isset($_POST["delete_photo_submit"]) && !empty($_POST["photoTitle"])){

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          // Check connection
        if ($mysqli->connect_errno) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $pTitle = $_POST["photoTitle"];

        $statement = "DELETE FROM photos
            WHERE ptitle= '$pTitle' "; 
        $result = $mysqli->query($statement);
        echo "<h2>Photo deleted!</h2>"; 

       
        
               
    }

?>

</div>
</body>
</html>