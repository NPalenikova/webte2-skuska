<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'student'){
        header("location: ../index.php");
    }
    else{
        header("location: ../index.php");
    }
    exit;  
}

require_once "../config.php";
$danger = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $userType = $_POST["userType"];

    if (checkEmpty($email) === true) {
        $errmsg .= "<p>Please enter email.</p>";
    } 
    elseif (checkLength($email, 10, 127) === false) {
        $errmsg .= "<p>Email has incorrect length.</p>";
    }
    elseif (checkStuba($email)) {
        $errmsg .= "<p>Please use a university email.</p>";
    }

    if (checkEmpty($user_password) === true) {
        $errmsg .= "<p>Please enter a password.</p>";
    }
    elseif(checkLength($user_password, 8, 20) === false){
        $errmsg .= "<p>Password has incorrect length.</p>";
    }

    if(empty($errmsg)){
        try {
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            if($userType == 'student'){
                $sql = "SELECT name, surname, id from student where email= :email";
                $stmt = $db->prepare($sql);
        
            }
            else if($userType == 'teacher'){
                $sql = "SELECT name, surname, id from teacher where email= :email";
                $stmt = $db->prepare($sql);
            }
            
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    // Uzivatel existuje, skontroluj heslo.
                    $row = $stmt->fetch();
                    $hashed_password = $row["password"];
        
                    if (password_verify($user_password, $hashed_password)) {
                        // Heslo je spravne.
                        // Uloz data pouzivatela do session.
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row['id'];
                        $_SESSION["fullname"] = $row['name'] . " " . $row['surname'];
                        $_SESSION["userType"] = $userType;
                        if($userType == 'student'){
                            //student 1st page
                            //header("location: restricted.php");
                        }
                        elseif($userType == 'teacher'){
                            //teacher 1st page
                            //header("location: restricted.php");
                        }
                        $userFound = true;
                        
                    } else {
                        $errmsg .= "<p>Incorrect email or password.</p>";
                    }
                } else {
                    $userFound = false;
                }
            } else {
                $errmsg .= "<p>Oops, something went wrong.</p>";
            }
        
        
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
}
else{
    $danger = true;
    $userFound = true;
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
    if (!preg_match('/^[\w.+\-]+@stuba\.sk$/', trim($email))) {
        return false;
    }
    return true;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if (!empty($errmsg)) {
            echo $errmsg;
        }

        if($danger){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">How did you get here? Please   </p>
                <a class="btn btn-primary" href="login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Log In</a>
                <p class="m-0 px-1">   first.</p>
            </div>';
        }

        if(!$userFound){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">User was not found, please   </p>
                <a class="btn btn-primary" href="../signup/signup.html" role="button" style="background-color: #1261A0; border-color:#1261A0;">Sign Up</a>
                <p class="m-0 px-1">   first.</p>
            </div>';
        }
    ?>
</body>
</html>