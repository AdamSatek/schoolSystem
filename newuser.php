<?php include_once "header.php"; 

if (isset($_SESSION["userId"]) && $_SESSION["userType"] === "teacher") { 
    require_once "teacher.menu.php";
}
?>

<section class="add-box">
    <h3>Add new user</h3>
    <form action="includes/newuser.inc.php" method="POST">
        <input type="text" name="name" placeholder="Full name...">
        <input type="text" name="contactPerson" placeholder="Contact person...">
        <input type="text" name="email" placeholder="Email...">
        <input type="text" name="phone" placeholder="Phone number...">
        <input type="password" name="pwd" placeholder="Password...">
        <select name="userType">
            <option value="" selected disabled hidden>User type</option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
        </select>
        <select name="classRoom" >
            <option value="0" selected hidden>Classroom</option>
            <option value="1">1.</option>
            <option value="2">2.</option>
            <option value="3">3.</option>
            <option value="4">4.</option>
            <option value="5">5.</option>
        </select>
        <button type="submit" name="createNewUser">Add user</button>
    </form>

</section>