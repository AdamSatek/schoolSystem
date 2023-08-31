<?php 
include_once "header.php";
if(isset($_SESSION["userId"]) && $_SESSION["userType"] === "student"){

    require_once "student.php";

} elseif (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 

    require_once "teacher.php";

} else {
    header("location: login.php");
}

include_once "footer.php";
