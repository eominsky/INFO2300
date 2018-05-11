<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Search</title>
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

	<div id="searchItemForm" class="forms">
	<!-- 	This form will take search inputs-->	

		<h2> Search!</h2>
	<form id="search" method="post">
		<p>Enter Search Here: <input type="text" name="search"></p>
			<p><input type="submit" name="search_submit"></p>
	</form>
	</div>

	  <?
	  if (isset($_POST["search_submit"]) && !empty($search = $_POST["search"])){
	  	$search = filter_input( INPUT_POST, 'search', FILTER_SANITIZE_STRING );
        
		require_once 'includes/config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		echo "<h2>Results Found:</h2>";

		//search photos
        $result1 = $mysqli->query("SELECT * FROM photos WHERE ptitle LIKE '%$search%' OR credit LIKE '%$search%'"); 
        while ($row = $result1->fetch_assoc()) {
	        echo "<div class='entry'>";
	        echo '<a href="indivPhoto.php?id='.$row['photoID'].'"><h4>'. $row['ptitle']."</h4></a>";
	        echo "<img src=images/".$row['fileName']." alt='".$row['ptitle']."'>"; 
	        echo "<p class='captions'>by ".$row['credit']."</p>";
	        echo "</div>";
        }
		//search albums
        $result2 = $mysqli->query("SELECT * FROM albums WHERE atitle LIKE '%$search%' OR description LIKE '%$search%'"); 
        	while ($albumrow = $result2->fetch_assoc()) {
        		echo '<a href="indivAlbum.php?id='.$albumrow['albumID'].'"><h3>'. $albumrow['atitle']."</h3></a>";
        }

             
    }
?>
    </div>
    </body>

</html>