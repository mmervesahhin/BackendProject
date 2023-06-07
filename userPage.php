<?php
session_start();
require "userDb.php";

// check if the user authenticated before
if (!validSession()) {
    header("Location: login.php?error"); // redirect to login page
    exit;
}

if(isset($_POST["accept"])){
    extract($_POST);
    
    $stmt = $db->prepare("insert into friends (user_id,friend_id) values (? , ?)") ;
    $stmt->execute([$from_id,$to_id]) ;
    
    // echo "<p>istek gönderildi</p>";
    exit;
}

$userData = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Network</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="jquery-3.7.0.min.js"></script>
    <script src="action.js"></script>
    </head>
<body>



    <div style="position: fixed; bottom: 0; left: 0;">
        <button><a id="logout" href="logout.php">Logout</a></button>
    </div>

    <h3>Welcome <?= $userData["name"] ?> (<?= $userData["email"] ?>)</h3>

    <script>
        var userData = <?php echo json_encode($userData); ?>;
    </script>

  
        <div id="profile-box">
            <button id="notification" onclick="toggleNotifications()"><i class="fa-solid fa-bell"></i></button>
            <img src="./images/<?= $userData["pp"] ?>" alt="Image" width="50" height="50" style="border-radius: 50%;">
            <span style="margin-left:10px;"><?= $userData["name"] ?>  <?= $userData["surname"]?></span>
        </div>

        <div id="friendList" style="position: fixed;top: 50;right: 0; border: 1px solid #ccc; margin-top:13px; width:235px; height:100%;">

        <h3>Your Friends</h3>
        <ul>
            
            <?php
               seeFriendList($userData["id"]);
            ?>

        </ul>
        </div>

    

        <div id="notificationsContainer" style="display: none;">
    <!-- Placeholder content for notifications -->
    <ul id="notificationList">
        <?php
        $userID = $userData["id"];
        $notifications = getNotifications($userID);
        $friendRequestData = array();
        foreach ($notifications as $notification) {
          
            echo '<li>' . $notification['content'];

            // echo "<div id='enes'>enes</div>";

            if ($notification['type'] == "Friend Request") {
                $query = "SELECT from_id, to_user_id FROM notifications WHERE id = ?";
                $stmt = $db->prepare($query);
                $stmt->execute([$notification['id']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $friendName="SELECT name,surname from users where id = ?";
                $st=$db->prepare($friendName);
                $st->execute([$row['from_id']]);
                $row2 = $st->fetch(PDO::FETCH_ASSOC);
                echo "<br>";
                echo "-". $row2['name']. " ". $row2['surname'];
                
                if ($row) {
                    $fromId = $row['from_id'];
                    $toUserId = $row['to_user_id'];

                    $friendRequestData[] = array(
                        'from_id' => $fromId,
                        'to_user_id' => $toUserId
                    );
                } else {
                    echo "Error executing query: " . $stmt->errorInfo()[2];
                }
                echo '<div class="button-container">';
                echo "<div class='invisible'>".$row['from_id']."</div>";
                echo "<div class='invisible'>".$row['to_user_id']."</div>";
                echo '<button class="accept-btn accept"><img src="./images/accept-button.png" alt="Accept" style="width: 20px; height: 20px;"></button>';
                echo '<button class="accept-btn reject"><img src="./images/reject-button.png" alt="Reject" style="width: 20px; height: 20px;"></button>';
                echo '</div>';
            }
            echo '</li>';
        }
        ?>
    </ul>
    

    </div>
    </div>

    <br><br><br><br>

    <form action="" method="post">
        <input type="text" id="searchText" name="friendSearch">
        <input type="submit" value="Search Friend" name="btnFriend">
    </form>

    <div id="searchPart">
        <br>
        <?php
        if (isset($_POST["btnFriend"])) {
            extract($_POST);
            if (!empty($friendSearch)) {
                $searched = searchFriend($friendSearch, $userData["id"]);
            }
        }
        ?>
        <br>

        <?php
        if (!empty($friendSearch)) {
            foreach ($searched as $s) {
                ?>
                <form action="search.php" method="POST">
                    <input type="hidden" name="sender" value="<?= $userData["id"] ?>">
                    <input type="hidden" name="receiver" value="<?= $s["id"] ?>">
                    <?php echo "<div>";
                    echo "<img style='border-radius:50%; width:30px; height:30px;' src='images/" . $s["pp"] . "'";
                    echo "<span> <div class='invisible'>" . $s["id"] . "</div>" . $s["name"] . " " . $s["surname"] . " (" . $s["email"] . ") <input type='submit' name='sbmtBtn' value='Send a Request' id='sendRequest'></span> ";
                    echo "</div>";
                    echo " </form>";
                }
            }
        ?>
        <p id="error"></p>
    </div>

    <div id="timeline">
        <div class="post" style="width:150px;">
            <?php
                    // Select all posts from the "posts" table
                    $sql = "SELECT * FROM posts";
                    $stmt = $db->query($sql);
                    
                    // Check if there are any posts
                    if ($stmt->rowCount() > 0) {
                        // Output data of each row
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Display post content
                            echo '<div class="post">';
                            echo '<img src="./posts/' . $row["content"] . '" alt="Image" width="100" height="100">';
                            echo '</div>';
                        }
                    } else {
                        echo "No posts found.";
                    }
                ?>
        </div>
    </div>

    <br>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="submit" value="Add Post" name="btnAddPost">
        <input type="file" name="content" id="content">
    </form>

    <?php 

        if ( isset($_POST["btnAddPost"])) {
            extract($_POST);

            require_once 'Upload.php';

            // Retrieve data
            $user_id=$userData["id"];
            $timestamp = date("Y-m-d H:i:s");

            // Upload profile picture
            $post = new Upload("content", "posts");

            if ($post->error) {
                echo "Error: " . $post->error;
            } else {
                // Insert user data into the database
                $stmt = $db->prepare("INSERT INTO posts (user_id, content, timestamp) VALUES (?, ?, ?)");
                $stmt->execute([$user_id, $post->filename, $timestamp]);
            
                // Redirect to a success page or display a success message
                echo "POST ADDED";
                exit;
            }
        }
        
    ?>
   
   <br>
    <br><br>
</body>
</html>
