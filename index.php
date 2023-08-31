<?php include_once 'header.php'?>

    <main>
        <section class="front-page">
           
            <h2>[SCHOOL NAME]</h2>
            <div class="intro-box img-first">
            </div>
                    
            <div class="intro-box txt-first">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est labore asperiores atque delectus debitis autem, distinctio eum beatae. Est nulla iste, asperiores doloremque eum vitae! Voluptates aliquam quia enim asperiores?</p>
            </div> 
                
            <div class="intro-box img-second">
            </div>
                    
            <div class="intro-box txt-second">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquam sapiente quisquam numquam porro iusto pariatur repellat aut quidem assumenda suscipit earum dolor nemo dolore excepturi repudiandae omnis, itaque vitae tempora.</p>
            </div> 
            
            <div class="intro-box img-third">
            </div>
                    
            <div class="intro-box txt-third">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat, quae suscipit doloremque quisquam debitis facilis doloribus laudantium, esse minus provident illo nisi fuga iste id accusantium ad reprehenderit et modi.</p>
            </div> 
                        
        </section>
        
        <section class="news-full">

        <p class="news-header">What's new in our school?</p>

            <?php
                $sqlNews = "SELECT * FROM news ORDER BY update_date desc;";
                $resultNews = mysqli_query($conn, $sqlNews);
                $resultNewsCheck = mysqli_num_rows($resultNews);
                if($resultNewsCheck > 0){
                    while ($rowNews = mysqli_fetch_assoc($resultNews)){
                        for ($i=0;$i<4 && $i<$resultNewsCheck;$i++) {
                            echo '<div class="newsContainer">
                            <img src="news/'.$rowNews["file_name"].'">
                            <div class="descNews">
                            <p>'.$rowNews["description_head"].'</p>
                            <p class="textNews">'. $rowNews["description_body"].'</p>
                            <p class="dateNews">'.$rowNews["update_date"].'</p>
                            </div>
                            </div>';
                        }
                       
                        

                    }
                } else {
                    echo '<p class="noNews">No news has been uploaded.</p>';
                }
            ?>
   
            <a href="news.php" style="flex:100%;text-decoration:none;color:black;">SHOW ALL...</a>
        </section>

       
</main>
<?php include_once 'footer.php'?>

    