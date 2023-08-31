<?php

if (isset($_POST["addPhoto"])){
    $file = $_FILES["imageGallery"];
    $description = $_POST["descriptionGallery"];

    $fileName = $_FILES["imageGallery"]["name"];
    $fileTmpName = $_FILES["imageGallery"]["tmp_name"];
    $fileSize = $_FILES["imageGallery"]["size"];
    $fileError = $_FILES["imageGallery"]["error"];
    $fileType = $_FILES["imageGallery"]["type"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array("jpg", "jpeg", "png");

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = uniqid("", true).".".$fileActualExt;
                $fileDestination = "../photogallery/".$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                require_once "dbconn.inc.php";
                $sql = "INSERT INTO gallery (photo_name, photo_destination, photo_description) VALUES ('$fileNameNew', '$fileDestination', '$description');";
                mysqli_query($conn, $sql);
                header("location: ../addphoto.php?successfull");
            } else {
                header("location: ../addphoto.php?error=maxSize");
            }
        } else {
            header("location: ../addphoto.php?error=tryAgain");
        }
    } else {
        header("location: ../addphoto.php?error=wrongFormat");
    }
}