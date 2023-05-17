<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'student'){
        header("location: ../student/stefanov.php");
    }
    else{
        header("location: ../teacher/teacher.php");
    }
    exit;  
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');
$danger = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $repeat_password = $_POST['repeatPassword'];
    $userType = $_POST["userType"];

    if(checkEmpty($name) || checkEmpty($surname) || checkEmpty($email) || checkEmpty($user_password) || checkEmpty($repeat_password) || checkEmpty($userType)){
        $errmsg .= "<p>Some of the data is missing.</p>";
    }

    if(!checkLength($name, 1, 127)) {
        $errmsg .= "<p>Name is too long.</p>";
    }

    if(!checkLength($surname, 1, 127)) {
        $errmsg .= "<p>Surname is too long.</p>";
    }

    if(!checkLength($email, 10, 127)) {
        $errmsg .= "<p>Email has incorrect length.</p>";
    }
    elseif(!checkStuba($email)) {
        $errmsg .= "<p>Please use a university email.</p>";
    }
    elseif(!isValidEmail($email)){
        $errmsg .= "<p>Your email contains prohibited characters.</p>";
    }

    if(!checkLength($user_password, 8, 20) || !checkLength($repeat_password, 8, 20)){
        $errmsg .= "<p>Password has incorrect length.</p>";
    }
    elseif(strcmp($user_password, $repeat_password) != 0){
        $errmsg .= "<p>Passwords don't match.</p>";
    }

    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $exist = userExists($db, $email, $userType);
    
        if($exist){
            $errmsg .= '<p>User with these credentials already exists. Please  </p>
            <a class="btn btn-primary" href="../login/login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Login</a>';
        }
    
        if (empty($errmsg)) {
    
            $hashed_password = password_hash($user_password, PASSWORD_ARGON2ID);
    
            if($userType == 'student'){
                $sql = "INSERT INTO student (email, password, name, surname) VALUES (:email, :password, :name, :surname)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
            }
            else if($userType == 'teacher'){
                $sql = "INSERT INTO teacher (email, password, name, surname) VALUES (:email, :password, :name, :surname)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
            }
    
            $stmt->execute();
            echo "Data has been stored in the database.";
        }
    
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
else{
    $danger = true;
    $errmsg = ' ';
}


//funkcie

function checkEmpty($field) {
    if (empty(trim($field))) {
        return true;
    }
    return false;
}

function checkLength($field, $min, $max) {
    $string = trim($field);
    $length = strlen($string);
    if ($length < $min || $length > $max) {
        return false;
    }
    return true;
}

function checkStuba($email) {
    if (preg_match('/@stuba\.sk$/', $email)) {
        return true;
    }
    return false;
}

function isValidEmail($email) {
    // Check if the email address contains only allowed characters
    if (preg_match('/^[^\s@]{3,}@[^\s@]+\.[^\s@]{2,4}$/', $email)) {
        return true;
    } else {
        return false;
    }
}

function userExists($db, $email, $userType){
    
    if($userType == 'student'){
        $sql = "SELECT name, surname, id from student where email= :email";
        $stmt = $db->prepare($sql);

    }
    else if($userType == 'teacher'){
        $sql = "SELECT name, surname, id from teacher where email= :email";
        $stmt = $db->prepare($sql);
    }
    
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        return true;
    }
    else{
        return false;
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <?php

        if($danger){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">How did you get here? Please   </p>
                <a class="btn btn-primary" href="login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Log In</a>
                <p class="m-0 px-1">   first.</p>
            </div>';
        }

        if (!empty($errmsg)) {
            echo $errmsg;
        }
        else{
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">Sign up was successful, you can   </p>
                <a class="btn btn-primary" href="../login/login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Login</a>
                <p class="m-0 px-1">   now.</p>
            </div>';
        }
    ?>
</body>
</html>