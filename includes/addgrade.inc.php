<?php

if (isset($_POST["addGrade"])){
    $index = $_POST["index"];
    $studentGroup = $_POST["student_group"];
    $className = $_POST["class_name"];
    $gradeForm = $_POST["grade_value"];

    

    for ($i=1; $i <= $index; $i++) {
        
        $student = "studentID".$i;
        $grade = "grade".$i;

        $studentID = $_POST["$student"];
        $gradeValue = $_POST["$grade"];

        if (empty($gradeValue)) {
            continue;
        }
        $sql = "INSERT INTO grades (user_id, subject, student_group, grade, grade_value) VALUES (?, ?, ?, ?, ?);";

        require_once "dbconn.inc.php";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../addgrade.php?error=stmtfailed");
            exit();
        }
    
        mysqli_stmt_bind_param($stmt, "sssss", $studentID, $className, $studentGroup, $gradeValue, $gradeForm);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
    header("location: ../addgrade.php?successfull");

} else {
    header("location: ../addgrade.php");
}