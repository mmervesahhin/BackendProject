<?php

  // connection string
  const DSN = "mysql:host=localhost;port=3306;dbname=test;charset=utf8mb4" ;
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

function searchFriend($friend){
   $sql = "SELECT email FROM users";
   global $db;
  
   $result = $db->query($sql);
   
   if ($result->rowCount() > 0 ) {
       while ($row = $result->fetch()) {
         if($friend==$row["email"])
           echo "You can add " . $row["email"] . "<br>";
       }
       
   } else {
       echo "There is no such a friend with this e-mail address.";
   }
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
