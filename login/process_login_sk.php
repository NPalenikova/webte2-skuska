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

require_once "../config.php";
$danger = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $userType = $_POST["userType"];

    if (checkEmpty($email)) {
        $errmsg .= "<p>Prosím zadajte email.</p>";
    } 
    elseif (!checkLength($email, 10, 127)) {
        $errmsg .= "<p>Email má nesprávnu dĺžku.</p>";
    }
    elseif (!checkStuba($email)) {
        $errmsg .= "<p>Prosím použite univerzitný email.</p>";
    }
    elseif(!isValidEmail($email)){
        $errmsg .= "<p>Email obsahuje zakázané znaky.</p>";
    }

    if (checkEmpty($user_password)) {
        $errmsg .= "<p>Prosím zadajte heslo.</p>";
    }
    elseif(!checkLength($user_password, 8, 20)){
        $errmsg .= "<p>Heslo má nesprávnu dĺžku.</p>";
    }

    if(empty($errmsg)){
        try {
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            if($userType == 'student'){
                $sql = "SELECT name, surname, id, password from student where email= :email";
                $stmt = $db->prepare($sql);
        
            }
            else if($userType == 'teacher'){
                $sql = "SELECT name, surname, id, password from teacher where email= :email";
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
                            header("location: ../student/studentTesty_sk.php");
                        }
                        elseif($userType == 'teacher'){
                            header("location: ../teacher/teacher.php");
                        }
                        $userFound = true;
                        
                    } else {
                        $errmsg .= "<p>Nesprávny email alebo heslo.</p>";
                    }
                } else {
                    $userFound = false;
                }
            } else {
                $errmsg .= "<p>Niečo sa pokazilo.</p>";
            }
        
        
        } catch(PDOException $e) {
            echo "Spojenie sa nepodarilo" . $e->getMessage();
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
    if (preg_match('/@stuba\.sk$/', trim($email))) {
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
?>


<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if (!empty($errmsg)) {
            echo $errmsg;
        }
        elseif($danger){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center">
                <p class="m-0 px-1">Ako si sa sem dostal? Prosím najprv sa   </p>
                <a class="btn btn-primary" href="login_sk.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihlás</a>
            </div>';
        }
        elseif(!$userFound){
            echo
            '<div class="d-flex flex-row justify-content-center align-items-center p-2">
                <p class="m-0 px-1">Používateľ nebol nájdený. Prosím najprv sa   </p>
                <a class="btn btn-primary" href="../signup/signup_sk.html" role="button" style="background-color: #1261A0; border-color:#1261A0;">Zaregistruj</a>
                <p class="m-0 px-1">   alebo znova  </p>
                <a class="btn btn-primary" href="login_sk.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihlás</a>
            </div>';
        }
        elseif(empty($errmsg) && !$danger && $userFound){
            echo"Welcome " . $_SESSION["fullname"];
        }
    ?>
</body>
</html>