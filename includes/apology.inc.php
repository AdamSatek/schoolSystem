<?php

if (isset($_POST["addApology"])) {

    session_start();
    
    $apologyTxt = htmlspecialchars($_POST["apologyTxt"]);
    
    $sendBy = $_SESSION["userId"];

    if (empty($apologyTxt)) {
        header("location: ../profile.php?error=emptyInput");
        exit;
    }

    $sql = "INSERT INTO apology (apology_txt, user_id) VALUES (?, ?);";
    require_once "dbconn.inc.php";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../profile.php?error=sqlError");
        die;
    } else {
    mysqli_stmt_bind_param($stmt, "ss", $apologyTxt, $sendBy);
    mysqli_stmt_execute($stmt);
    }
    header("location: ../profile.php?successfullyAdded");
    
    mysqli_stmt_close($stmt);
 
}