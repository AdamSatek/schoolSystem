<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
}
?>

<section class="add-box">
    <h3>Add picture to photogallery</h3>
    <form action="includes/photogallery.inc.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="imageGallery">
        <textarea name="descriptionGallery" placeholder="Short description..."></textarea>
        <button type="submit" name="addPhoto">Add picture to photogallery</button>
    </form>

</section>