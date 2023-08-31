<?php

function uidExists($conn, $name, $email){
    $sql = "SELECT * FROM users WHERE user_name = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../login.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emptyInputLogin($name, $password){
    $result;
    if(empty($name) || empty($password)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function emptyInputSignup($name, $email, $phone, $pwd, $userType){
    $result;
    if(empty($name) || empty($email) || empty($phone) || empty($pwd) || empty($userType)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $name, $password){
    $uidExists = uidExists($conn, $name, $name);

    if ($uidExists === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwd = $uidExists["pwd"];
    $checkPwd = password_verify($password, $pwd);

    if ($checkPwd === false){
        header("location: ../login.php?error=wrongpassword");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userId"] = $uidExists["user_id"];
        $_SESSION["userName"] = $uidExists["user_name"];
        $_SESSION["userType"] = $uidExists["user_type"];
        $_SESSION["studentGroup"] = $uidExists["student_group"];
        header("location: ../index.php");
        exit();
    }
}