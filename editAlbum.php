<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Album</title>
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
    <h2>Edit Album</h2>
    <form method="post" enctype="multipart/form-data">
    <p>Choose Album to edit:</p>
    <p><select name="choose_album">
    <?php
        require_once 'includes/config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $result = $mysqli->query("SELECT * FROM albums"); 
        while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row['albumID'].'">'.$row['atitle']. '</option>';
        }     
    ?>    
    </select></p>
    <p>New Album Name: <input type="text" name="albumTitle"></p>
    <p>New Description: <input type="text" name="aDesc"></p>
    <p><input type="submit" name="edit_album_submit"></p>
    </form>



<?php
        
        if (isset($_POST["edit_album_submit"]) && !empty($_POST["choose_album"])){
        $aID = $_POST["choose_album"];
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          // Check connection
        if ($mysqli->connect_errno) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if(! empty($_POST["albumTitle"])){
            $nTitle= $post_username = filter_input( INPUT_POST, 'albumTitle', FILTER_SANITIZE_STRING );
            $result = $mysqli->query("UPDATE albums SET atitle = '$nTitle' WHERE albums.albumID = '$aID'");

            $result = $mysqli->query("UPDATE albums SET dateModified = NOW() WHERE albums.albumID = '$aID'");
        }

        if(! empty($_POST["aDesc"])){
            $nDesc = filter_input( INPUT_POST, 'aDesc', FILTER_SANITIZE_STRING );
            $result = $mysqli->query("UPDATE albums SET description = '$nDesc' WHERE albums.albumID = '$aID'");
            $result = $mysqli->query("UPDATE albums SET dateModified = NOW() WHERE albums.albumID = '$aID'");
        }

        echo "<h2>album edited!</h2>";
        echo "<a href='albums.php'><h3>go back to all albums</h3></a>";
     
        
    }

?>

</div>
</body>
</html>