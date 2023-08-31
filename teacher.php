<?php require_once "teacher.menu.php"?>

<section class="apologies">
<?php 
    $user = $_SESSION["userId"];
    $username = $_SESSION["userName"];


    $sqlApology = "SELECT users.user_name, users.student_group, apology.apology_txt, apology.apology_date FROM apology INNER JOIN users ON apology.user_id=users.user_id;";
    $resultApology = mysqli_query($conn, $sqlApology);
    $resultApologyCheck = mysqli_num_rows($resultApology);
    

    if($resultApologyCheck > 0){
        
        echo "<table class='apology-table'><tr><th>Student name</th><th>Classroom</th><th>Text of apology</th><th>Date</th></tr>";

        while ($rowApology = mysqli_fetch_assoc($resultApology)){

            echo "<tr><td>".$rowApology["user_name"]."</td><td>".$rowApology["student_group"]."</td><td>".$rowApology["apology_txt"]."</td><td>".$rowApology["apology_date"]."</td></tr>";
    
        }

        echo "</table>";
    } else {
        echo "<tr><td colspan='4'>No apologies</td></tr>";
    }

?>
</section>
