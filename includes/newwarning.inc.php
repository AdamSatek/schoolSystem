<?php

if (isset($_POST["addWarning"])) {

    session_start();
    $forWho = $_POST["forWho"];
    $warningText = htmlspecialchars($_POST["warningText"]);
    $date = $_POST["date"];
    $sendBy = $_SESSION["userId"];

    if (empty($forWho) || empty($warningText) || empty($date)) {
        header("location: ../addwarning.php?error=emptyInput");
        exit;
    }

    $sql = "INSERT INTO warnings (for_who, warning_text, warning_date, inserted_by) VALUES (?, ?, ?, ?);";
    require_once "dbconn.inc.php";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../addwarning.php?error=sqlError");
        die;
    } else {
    mysqli_stmt_bind_param($stmt, "ssss", $forWho, $warningText, $date, $sendBy);
    mysqli_stmt_execute($stmt);
    }
    header("location: ../addwarning.php?successfullyAdded");
    
    mysqli_stmt_close($stmt);
 
}