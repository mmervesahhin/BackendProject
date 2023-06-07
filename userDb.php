<?php
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

function seeFriendList($id) {
  // $sql = "SELECT name,surname FROM users,friends where user_id=id";
   $sql = "SELECT u.name, u.surname 
        FROM users u
        JOIN friends f ON u.id = f.user_id or f.friend_id=u.id
        WHERE (f.friend_id = $id or f.user_id=$id) and u.id != $id" ; 

   global $db;

   $result = $db->query($sql);
   if ($result->rowCount() > 0) {
       while ($row = $result->fetch()) {
           echo "" . $row["name"] . " " . $row["surname"] ."<br>";
       }
   } else {
       echo "No friends.";
   }
} 

function searchFriend($friend,$id){
  global $db;
   $stmt = $db->prepare("SELECT * FROM users where (name=? or surname=? or email=?) and id != ? ");
   $stmt->execute([$friend,$friend,$friend,$id]);

  return $stmt->fetchAll();
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

function getNotifications($toUserId) {
  global $db;
  $stmt = $db->prepare("SELECT * FROM notifications WHERE to_user_id = ?");
  $stmt->execute([$toUserId]);
  return $stmt->fetchAll();
}