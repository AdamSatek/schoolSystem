<?php include_once "header.php" ?>

<section id="photogallery">
    <p class="gallery-header">Photogallery</p>
    <script src="scripts/photogallery.js"></script>
        <?php
            $sqlGallery = "SELECT * FROM gallery;";
            $resultGallery = mysqli_query($conn, $sqlGallery);
            $resultGalleryCheck = mysqli_num_rows($resultGallery);
            

            if($resultGalleryCheck > 0){
                $i = 1;
                $p = 0;
                while ($rowGallery = mysqli_fetch_assoc($resultGallery)){
    
                    echo "<div class='gallery-img img".$i."' style='background-image: ";
                    echo "url(photogallery";
                    echo "/";
                    echo $rowGallery["photo_name"].");'>";
                    echo "<div class='galleryDesc'><p>".$rowGallery["photo_description"]."</p>";
                    echo "<p class='galleryDate'>".$rowGallery["upload_date"]."</p></div></div>";

                    echo "<script>pictures[".$p."]='".$rowGallery["photo_name"]."';</script>";
                    $i++;
                    $p++;
                }
            } else {
                echo "No photos";
            }
        ?>
    

</section>
    


<?php include_once "footer.php" ?>