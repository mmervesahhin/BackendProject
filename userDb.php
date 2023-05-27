<?php

  // connection string
  const DSN = "mysql:host=localhost;port=8889;dbname=project;charset=utf8mb4" ;
  const USER = "root" ;
  const PASSWORD = "root" ; 

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

function getUser($email) {
   global $db ;
   $stmt = $db->prepare("SELECT * FROM users WHERE email = ?") ; 
   $stmt->execute([$email]) ;
   return $stmt->fetch() ; 
}

  function validSession() {
   return isset($_SESSION["user"]) ;
}
