<?php
  session_start() ;
  require "userDb.php" ;
  // check if the user authenticated before
  if( !validSession()) {
      header("Location: index.php?error") ; // redirect to login page
      exit ; 
  }
 
  $userData = $_SESSION["user"] ;
//   $userData = getUser($token) ;
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This is the user's main page after correctly login to her/his account</h1>
    
    <h3>Welcome <?= $userData["name"] ?></h3>
    <?= '<img src="./images/' . $userData["pp"] . '" alt="Image">' ?>
    <div>
        <a href="logout.php">Logout</a>
    </div>
    
</body>
</html>