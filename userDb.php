<?php

  // connection string
  const DSN = "mysql:host=localhost;port=3306;dbname=project;charset=utf8mb4" ;
  const USER = "root" ;
  const PASSWORD = "" ; 

  // connect to database, $db represents mysql dbms
  $db = new PDO(DSN, USER, PASSWORD) ; 

  function checkUser($email, $rawPass) {
   global $db ;
   $stmt = $db->prepare("SELECT * FROM users WHERE email = ?") ; 
   $stmt->execute([$email]) ;
   if ($stmt->rowCount()) {
      // email exists
      $user = $stmt->fetch() ;
      return password_verify($rawPass, $user["password"]) ;
   }
   return false ; 
}

function seeUser($email) {
   $sql = "SELECT email FROM users";
   global $db;
  
   $result = $db->query($sql);
   
   echo "Arkadaş ekleyebileceğin kişilerin e-posta'sı:";
   if ($result->rowCount() > 0) {
       while ($row = $result->fetch()) {
         if($email!=$row["email"])
           echo "" . $row["email"] . "<br>";
       }
   } else {
       echo "Kayıt bulunamadı.";
   }
}

function searchFriend($friend,$id){
  global $db;
   $stmt = $db->prepare("SELECT * FROM users where (name=? or surname=? or email=?) and id != ? ");
   $stmt->execute([$friend,$friend,$friend,$id]);

  return $stmt->fetchAll();
  
  //  $result = $db->query($sql);
   
  //  if ($result->rowCount() > 0 ) {
  //      while ($row = $result->fetch()) {
  //        if($friend==$row["email"] || $friend==$row["name"] || $friend==$row["surname"]){
  //          ?> <span class="invisible"><?=$row["id"] ?></span><img <?= 'src="./images/' . $row["pp"] . '" alt="Image"' ?> width="30" height="30" style="border-radius: 50%;">
  //           <?php echo "".$row["name"] ." " .$row["surname"]." (".$row["email"].")" ?> <i class="fa-solid fa-plus"></i> <?php echo "<br>";
           
  //         }
  //      }
      
  //  } else {
  //      echo "There is no such user";
  //  }
}

function getUser($email) {
   global $db ;
   $stmt = $db->prepare("SELECT * FROM users WHERE email = ?") ; 
   $stmt->execute([$email]) ;
   return $stmt->fetch() ; 
}

  function validSession() {
   return isset($_SESSION["user"]) ;
}

function sendFriendRequest($id,$user_id,$type,$content){  //
  global $db;
  try{
    $stmt=$db->prepare("insert into notifications (id,user_id,type,content) values (?, ?, ?, ?)");
    $stmt->execute([$id,$user_id,$type,$content]);
    // $id = $db->lastInsertId() ;
    return ["id" => $id, "user_id" => $user_id, "type" => $type, "content" => $content];
  } catch(PDOException $e) {
  return ["error" => "Error"] ;
}}