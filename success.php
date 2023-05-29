<h1>You registered succesfully!</h1>
<h3>You may login to your account now by using the button below</h3>

<form method="post">
        <button type="submit" name="login">Login</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["login"])) {
            // Redirect to page1.php
            header("Location: ./login.php");
            exit;
        }
}

?>