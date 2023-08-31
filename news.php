<?php include_once "header.php"?>

<main>
    <section class="news-full">

        <p class="news-header">What's new in our school?</p>

            <?php
                $sqlNews = "SELECT * FROM news ORDER BY update_date desc;";
                $resultNews = mysqli_query($conn, $sqlNews);
                $resultNewsCheck = mysqli_num_rows($resultNews);
                if($resultNewsCheck > 0){
                    while ($rowNews = mysqli_fetch_assoc($resultNews)){
                        echo '<div class="newsContainer">
                            <img src="news/'.$rowNews["file_name"].'">
                            <div class="descNews">
                            <p>'.$rowNews["description_head"].'</p>
                            <p class="textNews">'. $rowNews["description_body"].'</p>
                            <p class="dateNews">'.$rowNews["update_date"].'</p>
                            </div>
                            </div>';
                       
                        

                    }
                } else {
                    echo '<p class="noNews">No news has been uploaded.</p>';
                }
            ?>
    </section>

       
</main>

<?php include_once "footer.php" ?>


