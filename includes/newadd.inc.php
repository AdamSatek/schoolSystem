<?php

if (isset($_POST["addNews"])){
    $file = $_FILES["imagefile"];
    $descHead = $_POST["descHead"];
    $descBody = $_POST["descBody"];


    $fileName = $_FILES["imagefile"]["name"];
    $fileTmpName = $_FILES["imagefile"]["tmp_name"];
    $fileSize = $_FILES["imagefile"]["size"];
    $fileError = $_FILES["imagefile"]["error"];
    $fileType = $_FILES["imagefile"]["type"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array("jpg", "jpeg", "png");

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = uniqid("", true).".".$fileActualExt;
                $fileDestination = "../news/".$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                require_once "dbconn.inc.php";
                $sql = "INSERT INTO news (description_head, description_body, file_name, file_destination) VALUES ('$descHead', '$descBody', '$fileNameNew', '$fileDestination');";
                mysqli_query($conn, $sql);
                header("location: ../addnews.php?successfull");
            } else {
                header("location: ../addnews.php?error=maxSize");
            }
        } else {
            header("location: ../addnews.php?error=tryAgain");
        }
    } else {
       header("location: ../addnews.php?error=wrongFormat");
    }
}