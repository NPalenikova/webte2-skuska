<?php
/*
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
    $displayValue = 'none';
    header("location: ../index_sk.php");
}*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

$data = file_get_contents('php://input');

// Spracovanie dát v XML formáte
//$xml = simplexml_load_string($data);


/*
foreach ($xml->item as $item) {
    $name = $item->name;
    $age = $item->age;

    $ziakID= $item->studentId;
    $prikladID= $item->idprikladu;
    $sadaID= $item->sadaid;
    $check_problem= $item->porovnanie;
    $student_solution= $item->textodpoved;



}*/


//neplatny

    $ziakID=  $_POST["ziakID"];
    $prikladID= $_POST["prikladID"];
    $sadaID= $_POST["sadaID"];
    $check_problem= $_POST["check_problem"];
    $student_solution= $_POST["student_solution"];

/*
$ziakID=  4;
$prikladID= 6;
$sadaID= 2;
$check_problem= 1;
$student_solution= "a+a+a";
*/


var_dump($_POST);



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


    /*
try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);


    $sql ='INSERT INTO student_test VALUES :id_student';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_student', $ziakID);


    $idTest = null;
    $stmt->execute();

    $idTest = $conn->lastInsertId();


    $sql = "INSERT INTO problem_check (id_test, id_problem, check_problem, submitted, student_solution)
            VALUES (:id_test,:id_problem, :check_problem, 1 ,:student_solution)";

    //$stmt = $conn->prepare($sql);
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id_test', $idTest);
//    $stmt->bindParam(':id_test', $lastInsertedId);

    $stmt->bindParam(':id_problem', $prikladID);

    $stmt->bindParam(':check_problem', $check_problem);
    $stmt->bindParam(':student_solution', $student_solution);


    if ($stmt->execute()) {
        $response = array(
            'message' => 'Data inserted successfully. pre problem_check'
        );
    } else {
        $response = array(
            'error' => 'Error inserting data. pre problem_check'
        );
    }
    // Uzatvorenie pripojenia k databáze
    $conn = null;



} catch (PDOException $e) {
    $response = array(
        'error' => 'Database connection failed: ' . $e->getMessage()
    );
}
*/
header('Content-Type: application/json');
//echo json_encode($response);