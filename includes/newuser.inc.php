<?php

if (isset($_POST["createNewUser"])) {
    $name = htmlspecialchars($_POST["name"]);
    $contactPerson = htmlspecialchars($_POST["contactPerson"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $pwd = htmlspecialchars($_POST["pwd"]);
    $userType = $_POST["userType"];
    $classRoom = $_POST["classRoom"];
    $options = [
        'cost' => 12
    ];
    
    $pwdhashed = password_hash($pwd, PASSWORD_BCRYPT, $options);

    require_once "functions.inc.php";

    if (emptyInputSignup($name, $email, $phone, $pwd, $userType)) {
        
        header("location: ../newuser.php?error=emptyInput");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        header("location: ../newuser.php?error=wrongEmail");
        exit;
    }

    $sql = "INSERT INTO users (user_name, contact_person, email, phone, pwd, user_type, student_group) VALUES (?, ?, ?, ?, ?, ?, ?);";

    require_once "dbconn.inc.php";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../newuser.php?error=sqlError");
    } else {
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $contactPerson, $email, $phone, $pwdhashed, $userType, $classRoom);
    mysqli_stmt_execute($stmt);
    }
    header("location: ../newuser.php?successfullyAddUser");
    
    mysqli_stmt_close($stmt);
} else {
    header("location: ../newuser.php");
}