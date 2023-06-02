<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'Upload.php';
    require_once 'userDb.php';

    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDate = $_POST['birth_date'];

    $regex = '/(\w+)@((?:\w+\.){1,3}(?:com|tr))/iu' ;
    // Upload profile picture
    $profilePicture = new Upload("pp", "images");

    $a=0;
    $b=0;

    if ($profilePicture->error) {
        $a++;
    } 

    if (!(preg_match_all($regex,$email))) {
        $b++;
    } 

    if($a!==0 || $b!==0){
        if($a>0){
            echo "Error: " . $profilePicture->error . "<br>";
        }
        if($b>0){
            echo "Error: " . $email . " is invalid. ";
        }
        
        
    }

    else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the database
        $stmt = $db->prepare("INSERT INTO users (email, password, name, surname, pp, birth_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $hashedPassword, $name, $surname, $profilePicture->filename, $birthDate]);

        // Redirect to a success page or display a success message
        header("Location: success.php");
        exit;
    }    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Register</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>Email : <input type="text" name="email" value="<?= $email ?? "" ?>"></p>
        <p>Passw : <input type="password" name="pass" ></p>
        <p>Name : <input type="text" name="name"  value="<?= $name ?? "" ?>"></p>
        <p>Surname : <input type="text" name="surname" value="<?= $surname ?? "" ?>"></p>
        <p>Birth Date: <input type="date" name="birth_date" value="<?= $birthDate ?? "" ?>"></p>
        <p>Profile Picture : <input type="file" name="pp" value="<?= $pp ?? "" ?>"></p>
        <p><button>Register</button></p>
    </form>
</body>
</html>