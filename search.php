<?php
require "userDb.php";
if(isset($_POST["sbmtBtn"])){
    extract($_POST);
 
    $st = $db->prepare("SELECT user_id, friend_id FROM friends WHERE user_id = ? AND friend_id = ?");
    $st->execute([$sender, $receiver]);
    $st2 = $db->prepare("SELECT user_id, friend_id FROM friends WHERE friend_id = ? AND user_id = ?");
    $st2->execute([$sender, $receiver]);

    if ($st->rowCount() > 0 || $st2->rowCount() > 0){
        echo "<h2>You are already friends!</h2>";
        echo "<button><a style='text-decoration:none; color:inherit;' href='userPage.php'> Go Back to the Main Page</a></button>";
    }else {
    $type="Friend Request";
    $content="Would you like to be friends?";

    $stmt=$db->prepare("insert into notifications (from_id,to_user_id,type,content) values (?, ?, ?, ?)");
    $stmt->execute([$sender,$receiver,$type,$content]);
    
    echo "<h2>You successfully sended a friendship request to the user with the id ". $receiver."</h2>";
    echo "<button><a style='text-decoration:none; color:inherit;' href='userPage.php'> Go Back to the Main Page</a></button>";
    }
  }
?>


<!-- <meta http-equiv="refresh" content="3 url=http://localhost/256/BackendProject/userPage.php"> -->


<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Sended</title>
  <link rel="stylesheet"  href="style.css">
</head>
<body>
    
</body>
</html> -->