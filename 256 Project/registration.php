<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{

    require_once 'Upload.php';
    require_once 'userDb.php';

    $email = $_POST['email'];
    $password = $_POST['pass'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthDate = $_POST['birth_date'];

    $profilePicture = new Upload("pp", "images");

    if ($profilePicture->error) {
        echo "Error: " . $profilePicture->error;
    } else{
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (email, password, name, surname, pp, birth_date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email, $hashedPassword, $name, $surname, $profilePicture->filename, $birthDate]);

        header("Location: index.php?register=ok");
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
        <p>Email : <input type="text" name="email" ></p>
        <p>Passw : <input type="password" name="pass" ></p>
        <p>Name : <input type="text" name="name" ></p>
        <p>Surname : <input type="text" name="surname" ></p>
        <p>Birth Date: <input type="date" name="birth_date"></p>
        <p>Profile Picture : <input type="file" name="pp" ></p>
        <p><button>Register</button></p>
    </form>
</body>
</html>