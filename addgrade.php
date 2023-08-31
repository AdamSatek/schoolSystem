<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
   
}
if (isset($_POST["selectClass"])){

?>

<section class="add-box">
    <h3>Add grade</h3>
    <form action="includes/addgrade.inc.php" method="POST">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Classroom</th>
            <th>Subject</th>
            <th>Grade</th>

        </tr>

        
<?php
    $classRoom = $_POST["classRoom"];
    $className = $_POST["className"];
    $gradeValue = $_POST["gradeValue"];
    $index = 0;

    $sqlClass = "SELECT * FROM users WHERE student_group = ?;";
    $stmtClass = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtClass, $sqlClass)){
        header("location: addgrade.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmtClass, "s", $classRoom);
    mysqli_stmt_execute($stmtClass);

    $resultDataClass = mysqli_stmt_get_result($stmtClass);
    while ($rowClass = mysqli_fetch_assoc($resultDataClass)) {
        $index++;
        echo "<tr><td><input type='hidden' name='studentID".$index."' value='".$rowClass["user_id"]."'>".$index."</td>
                <td><input type='text' disabled name='student".$index."' value='".$rowClass["user_name"]."'></td>
                <td>".$rowClass["student_group"]."</td>
                <td>".$className."</td>
                
                <td><input type='text' name='grade".$index."' placeholder='Grade...'></td></tr>";
    }

    echo "<input type='hidden' name='index' value='".$index."'><input type='hidden' name='class_name' value='".$className."'><input type='hidden' name='student_group' value='".$classRoom."'><input type='hidden' name='grade_value' value='".$gradeValue."'>";
    mysqli_stmt_close($stmtClass);
    

?>
        </table>
        <button type="submit" name="addGrade">Add grade</button>
    </form>

</section>


<?php
} else {

?>
<section class="add-box">
    <h3>Add grade</h3>
    <form action="addgrade.php" method="POST">
        <select name="classRoom">
            <option value="" selected disabled hidden>Choose classroom</option>
            <option value="1">1.</option>
            <option value="2">2.</option>
            <option value="3">3.</option>
            <option value="4">4.</option>
            <option value="5">5.</option>
        </select>
        <select name="className">
            <option value="" selected disabled hidden>Choose subject</option>
            <option value="History">History</option>
            <option value="Math">Math</option>
            <option value="English">English</option>
            <option value="Geography">Geography</option>
        </select>
        <select name="gradeValue">
            <option value="" selected disabled hidden>Choose form</option>
            <option value="0">Verbal</option>
            <option value="1">Exam</option>
            <option value="2">Homework</option>
        </select>
        <button type="submit" name="selectClass">Pick classroom</button>
    </form>

</section>

<?php
}