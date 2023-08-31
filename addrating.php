<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
}
?>

<section class="add-box">
    

    <?php
    if (isset($_GET["student"])) {
    ?>
    
        <table>
        
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Classroom</th>
                <th>Select</th>
            </tr>
        

    <?php
        $student = "%".htmlspecialchars($_GET["student"])."%";
        // require_once "includes/dbconn.inc.php";
        $sql = "SELECT * FROM users WHERE user_name LIKE ?;";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: addrating.php?error=stmtError");
            exit;
        }

        mysqli_stmt_bind_param($stmt, "s", $student);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)){
            ?>
                <tr>
                <form action="" method="GET">
                    <td><input type="hidden" name="studentID" value="<?php echo $row["user_id"]?>"><?php echo $row["user_id"]?></td>
                    <td><input type="hidden" name="studentName" value="<?php echo $row["user_name"]?>"><?php echo $row["user_name"]?></td>
                    <td><?php echo $row["student_group"]?></td>
                    <td><button type="submit" name="setStudent">Select student</button>
                </form>
                </tr>

            <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="4" style="text-align:center;">No student found.</td>
            </tr>
        </table>
        
        <?php
        }

           
    } elseif (isset($_GET["setStudent"])) {
        $userId = $_GET["studentID"];
        $userName = $_GET["studentName"];

        echo "<h3>".$userName."</h3>";
    ?>

    <form action="includes/newrating.inc.php" method="POST">
        <input type="hidden" name="userId" value="<?php echo $userId?>">
        <textarea name="rateText" placeholder="Text of your rating..."></textarea>
        <select name="rateStatus">
            <option value="" disabled selected>Choose one</option>
            <option value="1">Positive</option>
            <option value="2">Negative</option>
        </select>
        <button type="submit" name="rateStudent">Add rating</button>
    </form>
    <?php
    } else {
    
    ?>

    <h3>Add rating</h3>
    <form action="" method="GET">
    
        <input type="text" name="student" placeholder="Name of student...">
        <button type="submit" name="search">Search for student</button>
    </form>
    
    <?php
    }
    ?>
</section>