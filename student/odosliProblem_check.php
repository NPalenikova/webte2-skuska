<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'teacher'){
        header("location: ../teacher/teacher.php");
    } 
    else{
        header("location: ../student/studentTesty.php");
    }
}
else{
    header("location: ../index.php");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

$data = file_get_contents('php://input');

$ziakID=  $_POST["ziakID"];
$prikladID= $_POST["prikladID"];
$sadaID= $_POST["sadaID"];
$check_problem= $_POST["check_problem"];
$student_solution= $_POST["student_solution"];

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $sql = "INSERT INTO student_test ( id_student) VALUES (:idhocico)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idhocico', $ziakID);
    $stmt->execute();
    $idTest = $conn->lastInsertId();


    $sql = "INSERT INTO problem_check (id_test, id_problem, check_problem, submitted, student_solution)
            VALUES (:test,:problem, :check, 1 ,:solution)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':test', $idTest);
    $stmt->bindParam(':problem', $prikladID);
    $stmt->bindParam(':check', $check_problem);
    $stmt->bindParam(':solution', $student_solution);
    $stmt->execute();


} catch (PDOException $e) {
    $response = array(
        'error' => 'Database connection failed: ' . $e->getMessage()
    );
}
header('Content-Type: application/json');