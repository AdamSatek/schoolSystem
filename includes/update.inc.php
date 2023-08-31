<?php

if (isset ($_POST['submitGrade'])){
    $studentID = $_POST['studentName'];
    $class = $_POST['className'];
    $grade = $_POST['grade'];

    require_once 'dbconn.inc.php';

    $sql = "INSERT INTO grades (user_id, class_name, grade) VALUES ('$studentID', '$class', '$grade');";
    $result = mysqli_query($conn, $sql);
    echo 'Successfull.';
}
else {
    echo 'Error!';
}