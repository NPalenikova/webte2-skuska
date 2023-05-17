<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('../config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //   $query = "SELECT description , solution  FROM problem";
        //  $stmt = $db->query($query);
        // $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $ziakID=null;
    $prikladID=null;
    $sadaID=null;
    $check_problem=null;
    $student_solution= null;


    if (isset($_POST)){
       $ziakID=  $_POST["ziakID"];
        $prikladID= $_POST["prikladID"];
        $sadaID= $_POST["sadaID"];
        $check_problem= $_POST["check_problem"];
        $student_solution= $_POST["student_solution"];

        echo "<br>ziakid " .$ziakID;
        echo "<br>prikladID ".  $prikladID;
        echo "<br>sadaID ".  $sadaID;
        echo "<br>check_problem ".  $check_problem;
        echo "<br>student_solution ".  $student_solution;


    }


    //prerobit pre moju
    function create_visitor($db, $data){
        $visitor_ip = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set($data["local_time"]);
        $timestamp = time();
        $formatted_time = date('Y-m-d H:i:s', $timestamp);
        var_dump($formatted_time);
        $stmt = $db->prepare("INSERT INTO visitor (ip, place, country, local_time, lat, lng, flag) VALUES (:ip, :place, :country, :local_time, :lat, :lng, :flag)");
        $stmt->bindParam(':ip', $visitor_ip);
        $stmt->bindParam(':place', $data["place"]);
        $stmt->bindParam(':country', $data["country"]);
        $stmt->bindParam(':local_time', $formatted_time);
        $stmt->bindParam(':lat', $data["lat"]);
        $stmt->bindParam(':lng', $data["lng"]);
        $stmt->bindParam(':flag', $data["flag"]);
        $stmt->execute();
    }

 
    function posliProblemCheck($db, $data){
        //ID?
        //lastinserted id metoda

        $stmt= $db->prepare("INSERT INTO problem_check (id_problem, check_problem, submitted, student_solution) VALUES ( :idp ,:pcheck, :sub, :stusol)");
        $stmt->bindParam(':id_problem', $id_problem);
        $stmt->bindParam(':check_problem', $check_problem);
        $stmt->bindParam(':submitted', $submitted);
        $stmt->bindParam(':student_solution', $student_solution);


        $stmt->execute();
        $lastId = $db->lastInsertId(); //dostanem id posledneho
        echo " "+$lastId;
    }
