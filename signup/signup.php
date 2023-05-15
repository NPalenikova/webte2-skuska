<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST["userType"];

    if(checkEmpty)

    
    // Validacia mailu
    if (!checkStuba($email)) {
        header('Location: signup.html');
        exit();
    }

    // Kontrola pouzivatela
    if (userExist($pdo, $email, $userType) === true) {
        header('Location: login.php');
    }


    // TODO: Validacia hesla
    // TODO: Validacia mena, priezviska

    if (empty($errmsg)) {
        $sql = "INSERT INTO users (fullname, login, email, password, 2fa_code) VALUES (:fullname, :login, :email, :password, :2fa_code)";

        $fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
        $email = $_POST['email'];
        $login = $_POST['login'];
        $hashed_password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

        // 2FA pomocou PHPGangsta kniznice: https://github.com/PHPGangsta/GoogleAuthenticator
        $g2fa = new PHPGangsta_GoogleAuthenticator();
        $user_secret = $g2fa->createSecret();
        $codeURL = $g2fa->getQRCodeGoogleUrl('Olympic Games', $user_secret);

        // Bind parametrov do SQL
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":fullname", $fullname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":2fa_code", $user_secret, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // qrcode je premenna, ktora sa vykresli vo formulari v HTML.
            $qrcode = $codeURL;
        } else {
            echo "Ups. Nieco sa pokazilo";
        }

        unset($stmt);
    }
    unset($pdo);
}


function checkEmpty($field) {
    // Funkcia pre kontrolu, ci je premenna po orezani bielych znakov prazdna.
    // Metoda trim() oreze a odstrani medzery, tabulatory a ine "whitespaces".
    if (empty(trim($field))) {
        return true;
    }
    return false;
}

function checkLength($field, $min, $max) {
    // Funkcia, ktora skontroluje, ci je dlzka retazca v ramci "min" a "max".
    // Pouzitie napr. pre "login" alebo "password" aby mali pozadovany pocet znakov.
    $string = trim($field);
    $length = strlen($string);
    if ($length < $min || $length > $max) {
        return false;
    }
    return true;
}

function checkStuba($email) {
    // Funkcia pre kontrolu, ci zadany email je stuba
    if (!preg_match('/^[\w.+\-]+@stuba\.sk$/', trim($email))) {
        return false;
    }
    return true;
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