<?php
  header("Content-Type: application/json") ;
  require "userDb.php" ;

  $method = $_SERVER["REQUEST_METHOD"] ;

    // REST API Endpoints
    $json = file_get_contents('php://input'); // access the body of the http request packet
    $input = json_decode($json) ;  // convert json string to php object

// Add Friend
if ( $method === "POST") {
    $out = sendFriendRequest($input->id,$input->user_id,$input->type,$input->content) ;
}

// Remove Friend
if ( $method === "DELETE") {
  
}

echo json_encode($out) ;