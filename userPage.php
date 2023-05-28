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
<html>
<head>
    <title>Social Network</title>
    <style>
        /* CSS styles for the page */
        #profile-box {
            float: right;
            margin: 10px;
            padding: 10px;
            margin-top:0px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        #timeline {
            margin: 10px;
        }
        
        .post {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        
        #next-button {
            margin: 10px;
        }

        #logout {
            text-decoration:none;
            color:black;
        }
    </style>
</head>
<body>
<?php
     if ( isset($_POST["btnFriend"])) {
        extract($_POST);
       // echo "<p>{$friendEmail}</p>";
        searchFriend($friendEmail);
     }
   
    ?>
    <form action="" method="post">
    <input type="text" id="searchText" name="friendEmail">
    <input type="submit" value="Search Friend" name="btnFriend">
    <div id="output"></div>

    <div id="profile-box">
        <img <?= 'src="./images/' . $userData["pp"] . '" alt="Image"' ?> width="50" height="50">
        <span><?= $userData["name"] ?>  <?= $userData["surname"]?></span>
    </div>
    
        <br><br><br><br>

    <div id="timeline">
        <div class="post">
            <h3>Post 1</h3>
            <p>This is the content of the first post.</p>
        </div>
        <div class="post">
            <h3>Post 2</h3>
            <p>This is the content of the second post.</p>
        </div>
        <!-- Add more posts here -->
    </div>
    </form>
    <button id="next-button">Next</button>

    <br><br>

    <div>
        <button><a id="logout" href="logout.php">Logout</a></button>
    </div>
    
    <script>
        // JavaScript code for handling the "Next" button click event
        var nextButton = document.getElementById('next-button');
        nextButton.addEventListener('click', loadNextPosts);
        
        function loadNextPosts() {
            // Code to retrieve the next 10 posts and append them to the timeline
        }

        
    </script>

<?php seeUser($userData["email"]);?>

<h3>Welcome <?= $userData["name"] ?></h3>
<h3>Welcome <?= $userData["email"] ?></h3>
</body>
</html>
