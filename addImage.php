<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Image</title>
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
<h2>Add Photo</h2>
    <form method="post" enctype="multipart/form-data">
    <p>Photo Name: <input type="text" name="photoTitle"></p>
    <p>Credit: <input type="text" name="pCredit"></p>
    <p><input type="file" name="new_file"></p>
    <p>Add to Album:</p>
    <?php
        require_once 'includes/config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $result = $mysqli->query("SELECT * FROM albums"); 
        while ($albumrow = $result->fetch_assoc()) {
            echo '<p><input type="checkbox" name="addedAlbum[]" value="'.$albumrow['albumID'].'">';
            echo $albumrow['atitle'].'</p>';
        }     
    ?>
    <p><input type="submit" name="photo_submit"></p>
    </form>

  <?php

    if (isset($_POST["photo_submit"]) && !empty($_POST["photoTitle"]) && !empty($_POST["pCredit"]) && !empty($_FILES["new_file"])){
        

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          // Check connection
        if ($mysqli->connect_errno) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ( ! empty( $_FILES['new_file'] ) ) {
                $newPhoto = $_FILES['new_file'];
                $originalName = $newPhoto['name'];
                if ( $newPhoto['error'] == 0 ) {
                    $tempName = $newPhoto['tmp_name'];
                    move_uploaded_file( $tempName, "images/$originalName");
                    $_SESSION['photos'][] = $originalName;
                    print("<p>The file $originalName was uploaded successfully.</p>");
                }
        }

        $vTitle = $_POST["photoTitle"];
        $vCredit = $_POST["pCredit"];
        $newPhoto = $_FILES['new_file'];
        $originalName = $newPhoto['name'];
  

        if (isset($_POST["addedAlbum"])){
            $statement1 = "INSERT INTO photos(ptitle, fileName, credit)
            VALUES ('".$vTitle."', '".$originalName."', '".$vCredit."')";
                $result = $mysqli->query($statement1);


                $result = $mysqli->query("SELECT MAX(photoID) from photos");
                
                $row = $result->fetch_row();
                $pid = $row[0];
                $vAlbums = $_POST["addedAlbum"];
                
                foreach ($vAlbums as $albumIndex){
                     

                    $statement2 = "INSERT INTO tables ( photoID, albumID)
                        VALUES ('$pid', '$albumIndex')";
                    $result = $mysqli->query($statement2);
                }

        }else{
            $statement = "INSERT INTO photos(ptitle, fileName, credit)
            VALUES ('".$vTitle."', '".$originalName."', '".$vCredit."')";
            $result = $mysqli->query($statement);
        }   
        
}

?>

</div>
</body>
</html>