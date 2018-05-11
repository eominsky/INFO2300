<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Album</title>
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
	<h2>Add Album</h2>
    <form method="post">
    <p>Album Name: <input type="text" name="albumTitle"></p>
    <p>Description: <input type="text" name="aDescription"></p>
    <p><input type="submit" name="album_submit"></p>
    </form>


  <?php
    //Get the connection info for the DB. 
		require_once 'includes/config.php';

	if (isset($_POST["album_submit"]) && !empty($_POST["albumTitle"]) && !empty($_POST["aDescription"])){
		

		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$date = date('Y-m-d H:i:s');
		$vAlbum = $_POST["albumTitle"];
		$vDesc = $_POST["aDescription"];
		
		// Check connection
		if ($conn->connect_errno) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$statement = "INSERT INTO albums ( atitle, dateCreated, description )
		VALUES ('$vAlbum', '$date', '$vDesc')";

		$conn = $conn->query($statement);
		echo "<h2>ALBUM ADDED!</h2>";
		echo "<a href='albums.php'><h3>go back to all albums</h3></a>";
	}
?>


</div>

</body>
</html>
