<section id="profile">
    <form action="includes/eindex.inc.php" method="POST"><button type="submit" name="eindex" id="generatePDF">Generate index in PDF</button></form>
    <button id="apologyBtn" onclick="document.getElementById('apologyForm').classList.toggle('hidden');">E-Apology</button>
    <form action="includes/apology.inc.php" method="POST" id="apologyForm" class="hidden">
        <textarea name="apologyTxt" placeholder="What's going on? ..."></textarea>
        <button type="submit" name="addApology">Send apology</button>
    </form>
<?php
    $user = $_SESSION["userId"];
    $username = $_SESSION["userName"];
    $studentGroup = $_SESSION["studentGroup"];

    $sqlWarning = "SELECT * FROM warnings WHERE for_who = 'all' OR for_who = ?;";
    $stmtWarning = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmtWarning, $sqlWarning)){
        header("location: profile.php?error=stmtError");
        exit;
    }

    mysqli_stmt_bind_param($stmtWarning, "s", $studentGroup);
    mysqli_stmt_execute($stmtWarning);
    $resultWarning = mysqli_stmt_get_result($stmtWarning);
    $resultCheck = mysqli_num_rows($resultWarning);
    if($resultCheck > 0){
        echo "<div class='warningBlock'>";
        while($rowWarning = mysqli_fetch_assoc($resultWarning)){
            $currentDate = strtotime("tomorrow");
            $warningDate = strtotime($rowWarning["warning_date"]);
            if($currentDate>$warningDate){
                continue;
            }

            echo "<div class='warning'><p>Warning on ".$rowWarning["warning_date"]."</p>";
            echo "<p>".$rowWarning["warning_text"]."</p>";
            echo "<p class='warningTimestamp'>".$rowWarning["warning_timestamp"]."</p></div>";
        }

        echo "</div>";
        mysqli_stmt_close($stmtWarning);

    }
?>
<h3>Online Index</h3>
<h3><?php echo $username?></h3>

<?php
    $sqlGrades = "SELECT * FROM grades WHERE user_id = ? AND subject = ?;";
    $stmtGrades = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmtGrades, $sqlGrades)){
        header("location: profile.php?error=stmtfailed");
        exit();
    }
    $classname = array("History", "Math", "English", "Geography");
    echo "<div class='gradeBlock'>";
    for ($n=0; $n < count($classname); $n++){
        echo "<table><tr><th>".$classname[$n]."</th></tr>";
        mysqli_stmt_bind_param($stmtGrades, "ss", $user, $classname[$n]);
        mysqli_stmt_execute($stmtGrades);

        $resultDataGrades = mysqli_stmt_get_result($stmtGrades);
        while ($rowGrades = mysqli_fetch_assoc($resultDataGrades)) {
        
        echo "<tr><td>".$rowGrades["grade"]." <span class='gradeDate'>( ".$rowGrades["grade_date"]." )</span></td></tr>";

        };
        echo "</table>";
    };
    echo "</div>";
    

    mysqli_stmt_close($stmtGrades);

   
    $sqlRating = "SELECT * FROM rating WHERE user_id = ? AND rate_status = ?;";
    $stmtRating = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmtRating, $sqlRating)){
        header("location: profile.php?error=stmtfailed");
        exit();
    }
    $rateStatus = array(1, 2);
    $rateName = array("Positive", "Negative");
    echo "<div class='rateBlock'>";
    for ($n=0; $n < count($rateStatus); $n++){
        echo "<table><tr><th>".$rateName[$n]."</th></tr>";
        mysqli_stmt_bind_param($stmtRating, "ss", $user, $rateStatus[$n]);
        mysqli_stmt_execute($stmtRating);

        $resultDataRating = mysqli_stmt_get_result($stmtRating);
        while ($rowRating = mysqli_fetch_assoc($resultDataRating)) {
        
        echo "<tr><td>".$rowRating["rate_text"]." <p><span class='rateDate'>( ".$rowRating["rate_date"]." )</span></p></td></tr>";

        };
        echo "</table>";
    };
    echo "</div>";
    
    mysqli_stmt_close($stmtRating);

?>


  
</section>
