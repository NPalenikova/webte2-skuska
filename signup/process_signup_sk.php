<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'student'){
        header("location: ../student/studentTesty_sk.php");
    }
    else{
        header("location: ../teacher/teacher_sk.php");
    }
}
else{
    $danger = true;
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
        $errmsg .= "<p>Niektoré dáta chýbajú.</p>";
    }

    if(!checkLength($name, 1, 127)) {
        $errmsg .= "<p>Meno je príliš dlhé.</p>";
    }

    if(!checkLength($surname, 1, 127)) {
        $errmsg .= "<p>Priezvisko je príliš dlhé.</p>";
    }

    if(!checkLength($email, 10, 127)) {
        $errmsg .= "<p>Email má nesprávnu dĺžku.</p>";
    }
    elseif(!checkStuba($email)) {
        $errmsg .= "<p>Prosím použite univerzitný email.</p>";
    }
    elseif(!isValidEmail($email)){
        $errmsg .= "<p>Email obsahuje zakázané znaky.</p>";
    }

    if(!checkLength($user_password, 8, 20) || !checkLength($repeat_password, 8, 20)){
        $errmsg .= "<p>Heslo má nesprávnu dĺžku.</p>";
    }
    elseif(strcmp($user_password, $repeat_password) != 0){
        $errmsg .= "<p>Heslá sa nezhodujú.</p>";
    }

    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $exist = userExists($db, $email, $userType);
    
        if($exist){
            $errmsg .= '<p>Používateľ s týmito údajmi už existuje. Prosím  </p>
            <a class="btn btn-primary" href="../login/login_sk.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihláste sa</a>';
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
            echo "Dáta boli uložené do databázy.";
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
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="process_signup.php">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
    <?php

        if($danger){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">Ako si sa sem dostal? Najprv sa prosím   </p>
                <a class="btn btn-primary" href="login_sk.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihlás</a>
            </div>';
        }

        elseif (!empty($errmsg)) {
            echo $errmsg;
        }
        elseif( empty($errmsg) && !$danger){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">Registrácia bola úspešná, teraz sa môžete   </p>
                <a class="btn btn-primary" href="../login/login_sk.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihlásiť</a>
            </div>';
        }
    ?>
</body>
</html>