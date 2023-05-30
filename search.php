<?php
require "userDb.php";
if(isset($_POST["sbmtBtn"])){
    extract($_POST);
    var_dump($gonderen);
    var_dump($alan);
 }
    $type="Friend request";
    $content="Would you like to be friends? please";

    try{
      $stmt=$db->prepare("insert into notifications (id,user_id,type,content) values (?, ?, ?, ?)");
      $stmt->execute([$gonderen,$alan,$type,$content]);
    } catch(PDOException $e) {
   
  }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3 url=http://localhost/256/BackendProject/userPage.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html> -->