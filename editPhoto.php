<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Photo</title>
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
    <h2>Edit Photo</h2>
    <form method="post" enctype="multipart/form-data">
    <p>Choose Photo to edit:</p>
    <p><select name="choose_photo">
    <?php
        require_once 'includes/config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $result = $mysqli->query("SELECT * FROM photos"); 
        while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['photoID'].'">'.$row['ptitle']. '</option>';
        }     
    ?>    
    </select></p>
    <p>New Photo Name: <input type="text" name="photoTitle"></p>
    <p>New Credit: <input type="text" name="pCredit"></p>
    <p><input type="submit" name="edit_photo_submit"></p>
    </form>



<?php

    if (isset($_POST["edit_photo_submit"]) && !empty($_POST["choose_photo"])){
        $pID = $_POST["choose_photo"];
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          // Check connection
        if ($mysqli->connect_errno) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if(! empty($_POST["photoTitle"])){
            $nTitle= $post_username = filter_input( INPUT_POST, 'photoTitle', FILTER_SANITIZE_STRING );
            $result = $mysqli->query("UPDATE photos SET ptitle = '$nTitle' WHERE photos.photoID = '$pID'");
        }

        if(! empty($_POST["pCredit"])){
            $nCredit = filter_input( INPUT_POST, 'pCredit', FILTER_SANITIZE_STRING );
            $result = $mysqli->query("UPDATE photos SET credit = '$nCredit' WHERE photos.photoID = '$pID'");
        }
        echo "<h2>photo edited!</h2>";
        echo "<a href='photos.php'><h3>go back to all photos</h3></a>";
        
    }

?>

</div>
</body>
</html>