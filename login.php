<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Password-Protected Site</title>
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
		<?php 
		$post_username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
		$post_password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
		if ( empty( $post_username ) || empty( $post_password ) ) {
		?>
			<h2>Log In</h2>
			<form action="login.php" method="post">
				<p>Username: <input type="text" name="username"> </p>
				<p>Password: <input type="password" name="password"> </p>
				<p><input type="submit" value="Submit"></p>
			</form>
			
		<?php

		} else {

			//Get the config file
			require_once 'includes/config.php';
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if( $mysqli->connect_errno ) {
				//uncomment the next line for debugging
				echo "<p>$mysqli->connect_error<p>";
				die( "Couldn't connect to database");
			}
			
			//Check for a record that matches the POSTed username

			$result = $mysqli->query("SELECT * FROM users WHERE
							username = '".$post_username."' ");
			

			//Make sure there is exactly one user with this username
			if ( $result && $result->num_rows == 1) {
				
				$row = $result->fetch_assoc();
				
				$db_hash_password = $row['hashpassword'];
			
				if( password_verify( $post_password, $db_hash_password ) ) {
					$db_username = $row['username'];
					$_SESSION['logged_user_by_sql'] = $db_username;
				}
			} 
			
			$mysqli->close();
			
			if ( isset($_SESSION['logged_user_by_sql'] ) ) {
				print("<p>Congratulations, $db_username! You have logged in.<p>");

				echo ' You can now access these pages:
				<a href="addImage.php"><h3>Add Photo</h3></a>
	            <a href="addAlbum.php"><h3>Add Album</h3></a>
	            <a href="search.php"><h3>Search</h3></a>
	            <a href="delete.php"><h3>Delete</h3></a>
	            <a href="editAlbum.php"><h3>Edit Album</h3></a>
	            <a href="editPhoto.php"><h3>Edit Photo</h3></a>
	            <a href="login.php"><h3>Login</h3></a>
	            <a href="logout.php"><h3>Logout</h3></a>" ';	

			} else {
				echo '<p>You did not login successfully.</p>';
				echo '<p>Please <a href="login.php">try</a> again.</p>';
			}
			
		} //end if isset username and password
			
		?>
		</div>
	</body>
</html>