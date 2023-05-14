<?php
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$userType = $_POST["userType"];

// Server-side validation
if ($name == "" || $surname== "" || $email == "" || $password == "") {
  echo "All fields are required.";
} else {
    var_dump ($_POST);
}
?>