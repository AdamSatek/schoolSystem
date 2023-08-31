<?php
    include_once 'header.php';
?>

<main  class="loginForm">
    <div>
        <form action="includes/login.inc.php" method="POST">
            <input type="text" name="uid" placeholder="Username / Email...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">Log in</button>
        </form>
    </div>
   
</main>

<?php
    include_once 'footer.php';
?>
