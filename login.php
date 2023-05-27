<?php
  session_start();
  require "userDb.php" ;
  
  // auto login 
  if ( validSession()) {
      header("Location: userPage.php") ;
      exit ;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .hint { color: #AAA; font-style: italic }
        .error { color: red; font-style: italic;}
    </style>
</head>
<body>
    <?php
    // Authentication
     if ( !empty($_POST)) {
        extract($_POST) ;
        if ( checkUser($email, $pass) ) {
            // the user is authenticated
            // Store data to use in other php files. 
            $_SESSION["user"] = getUser($email) ;
            header("Location: userPage.php") ; // redirect to main page
            exit ;
        }
        $authError = true ;
    }
    ?>
    <h1>Login</h1>
    <form action="?" method="post">
        Email : <input type="text" name="email" value="<?= $email ?? '' ?>">
        <br><br>
        Passw : <input type="password" name="pass" >
        <br><br>
        <button type="submit">Enter</button>
    </form>
    

    <?php
      // Authentication Error Message
      if( isset($authError)) {
        echo "<p class='error'>Wrong email or password</p>" ;
      }

      // Direct access to main page error message
      if ( isset($_GET["error"])) {
          echo "<p class='error'>You tried to access main.php directly</p>" ;
      }

    ?>
</body>
</html>