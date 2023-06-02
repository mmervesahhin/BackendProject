<?php
session_start();
require "userDb.php";

// check if the user authenticated before
if (!validSession()) {
    header("Location: index.php?error"); // redirect to login page
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
    </head>
<body>

    <h3>Welcome <?= $userData["name"] ?> (<?= $userData["email"] ?>)</h3>

    <script>
        var userData = <?php echo json_encode($userData); ?>;
    </script>

    <div id="userPageContainer">
        <div id="profile-box">
            <button id="notification" onclick="toggleNotifications()"><i class="fa-solid fa-bell"></i></button>
            <img src="./images/<?= $userData["pp"] ?>" alt="Image" width="50" height="50" style="border-radius: 50%;">
            <span style="margin-left:10px;"><?= $userData["name"] ?>  <?= $userData["surname"]?></span>
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
            if ($notification['type'] == "Friend Request") {
                $query = "SELECT from_id, to_user_id FROM notifications WHERE id = ?";
                $stmt = $db->prepare($query);
                $stmt->execute([$notification['id']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $fromId = $row['from_id'];
                    $toUserId = $row['to_user_id'];

                    $friendRequestData[] = array(
                        'notificationId' => $notification['id'],
                        'from_id' => $fromId,
                        'to_user_id' => $toUserId
                    );
                } else {
                    echo "Error executing query: " . $stmt->errorInfo()[2];
                }
                echo '<div class="button-container">';
                echo '<button class="accept-btn" id="' . $notification['id'] . '"><img src="../images/accept-button.png" alt="Accept" style="width: 20px; height: 20px;"></button>';
                echo '<button class="accept-btn" id="' . $notification['id'] . '" "><img src="../images/reject-button.png" alt="Reject" style="width: 20px; height: 20px;"></button>';
                echo '</div>';
            }
            echo '</li>';
        }
        ?>
    </ul>
</div>

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

    <script>
        function toggleNotifications() {
            var container = document.getElementById('notificationsContainer');
            if (container.style.display === 'block') {
                container.style.display = 'none';
            } else {
                container.style.display = 'block';
            }
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var acceptButtons = document.getElementsByClassName('accept-btn');

        for (var i = 0; i < acceptButtons.length; i++) {
            acceptButtons[i].addEventListener('click', handleAcceptButtonClick);
        }

        function handleAcceptButtonClick(event) {
            // Get the notification ID associated with the clicked button
            var notificationId = event.target.id;
            
            // Perform any further actions you want with the notification ID
            // For example, you can make an AJAX request to update the database
            
            // Output the notification ID to the console for testing
            console.log('Accept button clicked for notification ID:', notificationId);
        }
    });
</script>


    <!-- <?php seeUser($userData["email"]);?> -->

</body>
</html>
