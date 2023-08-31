<?php
    include_once 'includes/dbconn.inc.php';
    session_start();

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Fredericka the Great' rel='stylesheet'>
    <link rel="stylesheet" href="styles/userstyle.css">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/gallery.css">
    <link rel="stylesheet" href="styles/news.css">
    
    
    <title>[SCHOOL NAME]</title>
</head>
<body>
    <header>
        <a href="index.php" id="logo"><img src="icons/logoPouzdranyW.png" alt="[SCHOOL NAME]"></a>
        <img src="icons/menu.png" id="menuBtn" alt="menu" onclick="document.getElementById('mainMenu').classList.toggle('hidden');">
        <ul id="mainMenu" class=""> 
            <?php

            if(isset ($_SESSION["userId"])){
                echo '<li><a href="includes/logout.inc.php">Log out</a></li>';
                echo '<li><a href="profile.php">Profil - '.$_SESSION["userName"].'</a></li>';
                
            } else {
                echo '<li><a href="login.php">Portal</a></li>';
            }
            
            ?>
            <li><a href="news.php">News</a></li>
            <li><a href="menu.php">Lunch</a></li>
            <li><a href="gallery.php">Photogallery</a></li>
        </ul>
    
    </header>
    
    