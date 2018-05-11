<?php session_start(); ?>
<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home</title>
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

    <h2>Plants are COOL!</h2>
    
    <div id="center">
    <img src="images/home_plant.jpg" alt="Hortus Forum Plants">
    <p class="captions"> Photo taken by Hortus Forum</p>
    </div>
  
</div> 

</body>

</html>