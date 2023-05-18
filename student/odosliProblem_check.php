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
    $displayValue = 'none';
    header("location: ../index_sk.php");
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('../config.php');


    $ziakID=  $_POST["ziakID"];
    $prikladID= $_POST["prikladID"];
    $sadaID= $_POST["sadaID"];
    $check_problem= $_POST["check_problem"];
    $student_solution= $_POST["student_solution"];


try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

    $sql ="INSERT INTO `student_test`( `id_student`) VALUES (:studentID)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':studentID', $ziakID);

    $idTest = null;
    if ($stmt->execute()) {
        $lastInsertedId = $conn->lastInsertId();
        $response = array(
            'message' => 'Data inserted successfully. pre student_test',
            'id_test' => $idTest
        );
    } else {
        $response = array(
            'error' => 'Error inserting data. pre student_test'
        );
    }

    if ($idTest !== null) {
        // Použite premennú `$idTest` podľa potreby
        echo "ID testu: " . $idTest;
    }



    // Použitie posledného ID
    echo "Posledne vytvorene ID: " . $lastInsertedId;

    $sql = "INSERT INTO problem_check (id_test, id_problem, check_problem, submitted, student_solution)
            VALUES (:id_test,:id_problem, :check_problem, 1 ,:student_solution)";
    //$stmt = $conn->prepare($sql);
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_test', $idTest);
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

header('Content-Type: application/json');
echo json_encode($response);