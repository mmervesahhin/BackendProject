<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Form Example</title>
</head>
<body>
    <h1>Welcome To the Application</h1>
    <h2>Please login if you have an account, if not you are welcome to register</h2>
    
    <form method="post">
        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Register</button>

    </form>
    
    <?php
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (isset($_POST["login"])) {
            // Redirect to page1.php
            header("Location: ./login.php");
            exit;
        } elseif (isset($_POST["register"])) {
            // Redirect to page2.php
            header("Location: ./registration.php");
            exit;
        }

    }
        
    ?>
    
</body>
</html>