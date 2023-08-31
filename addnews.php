<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
}
?>

<section class="add-box">
    <h3>Add news</h3>
    <form action="includes/newadd.inc.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="imagefile">
        <textarea name="descHead" placeholder="Heading..."></textarea>
        <textarea name="descBody" placeholder="Text..."></textarea>
        <button type="submit" name="addNews">Add news</button>
    </form>

</section>