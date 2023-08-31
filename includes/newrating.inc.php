<?php

if(isset($_POST["rateStudent"])){
    $user_id = htmlspecialchars($_POST["userId"]);
    $rate_text = htmlspecialchars($_POST["rateText"]);
    $rate_status = htmlspecialchars($_POST["rateStatus"]);

    $sql = "INSERT INTO rating (user_id, rate_text, rate_status) VALUES (?, ?, ?);";
    require_once "dbconn.inc.php";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../addrating.php?error=stmtError");
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sss", $user_id, $rate_text, $rate_status);
    mysqli_stmt_execute($stmt);

    header("location: ../addrating.php?successfull");

    mysqli_stmt_close();
}