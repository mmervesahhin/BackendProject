<?php
require "userDb.php";
if(isset($_POST["sbmtBtn"])){
    extract($_POST);
 }
    $type="Friend Request";
    $content="Would you like to be friends?";

    $stmt=$db->prepare("insert into notifications (from_id,to_user_id,type,content) values (?, ?, ?, ?)");
    $stmt->execute([$sender,$receiver,$type,$content]);
?>


<!-- <meta http-equiv="refresh" content="3 url=http://localhost/256/BackendProject/userPage.php"> -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Sended</title>
  <link rel="stylesheet"  href="style.css">
</head>
<body>
    <h2>You successfully sended a friendship request to the user with the id <?= $receiver ?></h2>
    <button><a style="text-decoration:none; color:inherit;" href="userPage.php"> Go Back to the Main Page</a></button>
</body>
</html>