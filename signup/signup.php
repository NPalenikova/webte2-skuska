<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['repeatPassword'];
    $userType = $_POST["userType"];

    var_dump($_POST);

    if(checkEmpty($name) || checkEmpty($surname) || checkEmpty($email) || checkEmpty($password) || checkEmpty($password2) || checkEmpty($userType)){
        $errmsg .= "<p>Data input was not correct.</p>";
    }

}

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

function checkPassword($password, $password2){
    $pattern = "/^[a-zA-Z0-9]{8,20}$/";

    if (preg_match($pattern, $password) && $password === $password2){
        return true;
    }
    return false;
}

function userExist($db, $email, $userType) {
    $exist = false;

    $param_email = trim($email);

    if($userType == 'student'){
        $sql = "SELECT id FROM student WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
    }
    else if($userType == 'teacher'){
        $sql = "SELECT id FROM teacher WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
    }
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $exist = true;
    }
    unset($stmt);
    return $exist;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if (!empty($errmsg)) {
            // Tu vypis chybne vyplnene polia formulara.
            echo $errmsg;
        }
    ?>
</body>
</html>