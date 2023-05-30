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
    <link rel="stylesheet"  href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="jquery-3.7.0.min.js"></script>
</head>
<body>

    <h3>Welcome <?= $userData["name"] ?> (<?= $userData["email"] ?>)</h3>

    
    <script>
    var userData = <?php echo json_encode($userData); ?>;
    </script>

    <div id="profile-box">
        <button id="notification"><i class="fa-solid fa-bell"></i></button>
        <img <?= 'src="./images/' . $userData["pp"] . '" alt="Image"' ?> width="50" height="50" style="border-radius: 50%;">
        <span style="margin-left:10px;"><?= $userData["name"] ?>  <?= $userData["surname"]?></span>
    </div>
    
        <br><br><br><br>

    <form action="" method="post">
    <input type="text" id="searchText" name="friendSearch">
    <input type="submit" value="Search Friend" name="btnFriend">
    </form>
    <div id="searchPart">
        <br>
    <?php
     if ( isset($_POST["btnFriend"])) {
        extract($_POST);
        $searched=searchFriend($friendSearch,$userData["id"]);
     }
    ?>
        <br>
    
    <?php

     foreach($searched as $s){
        ?>
        <form action="search.php" method="POST">
        <input type="hidden" name="gonderen" value="<?= $userData["id"] ?>">
        <input type="hidden" name="alan" value="<?= $s["id"] ?>">
        <?php echo "<div>";
       
        echo "<img style='border-radius:50%; width:30px; height:30px;' src='images/".$s["pp"]."'";
        echo "<span> <div class='invisible'>".$s["id"]."</div>".$s["name"] . " ".$s["surname"]." (". $s["email"]. ") <input type='submit' name='sbmtBtn' value='Send a Request' id='sendRequest'></span> ";
        echo "</div>";
        echo " </form>";
     }
    ?>
   <!-- <script>
        $(document).ready(function(){
            $("#sendRequest").click(function(){
                
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    success:function(response){
                        alert("oldu");
                        // $requestedFriend=$(this).prev();
                        // $type="Friendship Request";
                        // $content="Would you like to be friends?";
                        // $("#sendRequest").removeClass("fa-plus").addClass("fa-minus");
                        // console.log($requestedFriend);
                        // console.log($type);
                        // console.log($content);
                        // sendFriendRequest($userData["id"],$requestedFriend,$type,$content);
                    },
                    error: function(){
                        alert("Error!");
                    }
                })
            })

        })
       
    </script>
     -->
    <p id="error"></p>
    </div>

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
   
    <button id="next-button">Next</button>

    <br><br>

    <div>
        <button><a id="logout" href="logout.php">Logout</a></button>
    </div>
    
    <!-- Next button will be updated -->
    <!-- <script>
        // JavaScript code for handling the "Next" button click event
        var nextButton = document.getElementById('next-button');
        nextButton.addEventListener('click', loadNextPosts);
        
        function loadNextPosts() {
            // Code to retrieve the next 10 posts and append them to the timeline
        }

        
    </script> -->

<?php seeUser($userData["email"]);?>

</body>
</html>
