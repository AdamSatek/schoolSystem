<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
}
?>

<section class="add-box">
    <h3>Add warning</h3>
    <form action="includes/newwarning.inc.php" method="POST">
    <select name="forWho">
            <option value="" selected disabled hidden>For who...</option>
            <option value="all">to all</option>
            <option value="1">1.</option>
            <option value="2">2.</option>
            <option value="3">3.</option>
            <option value="4">4.</option>
            <option value="5">5.</option>
        </select>
        <input type="date" name="date">
        <textarea name="warningText" placeholder="Your message..."></textarea>
        
        <button type="submit" name="addWarning">Add warning</button>
    </form>

</section>