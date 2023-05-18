<?php


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

    // Vytvorenie prikazu s parametrami
    /*$sql = "INSERT INTO your_table_name (ziakID, prikladID, sadaID, check_problem, student_solution)
            VALUES (:ziakID, :prikladID, :sadaID, :check_problem, :student_solution)";*/

    $sql = "INSERT INTO problem_check (id_problem, check_problem, submitted, student_solution)
            VALUES (:id_problem, :check_problem, :sadaID, :check_problem, :student_solution)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_problem', $prikladID);
    //$stmt->bindParam(':prikladID', $prikladID);
    $stmt->bindParam(':sadaID', $sadaID);
    $stmt->bindParam(':check_problem', $check_problem);
    $stmt->bindParam(':student_solution', $student_solution);

    //not worky
    if ($stmt->execute()) {
        $response = array(
            'message' => 'Data inserted successfully.'
        );
    } else {
        $response = array(
            'error' => 'Error inserting data.'
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