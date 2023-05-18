<?php
session_start();

require_once('../config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

$ziakIdPrihlaseny=  $_SESSION["id"];

$hladamSady =  "SELECT *  FROM student_test 
                 INNER JOIN problem_check ON student_test.id_test = problem_check.id_test 
                 INNER JOIN problem ON problem_check.id_problem = problem.id
                WHERE student_test.id_student = :idZiaka;
                 ";
$stmt = $db->prepare($hladamSady);
$stmt->bindParam(":idZiaka",$ziakIdPrihlaseny );
$stmt->execute();

$zistujemodovzdane = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

<h1>Submitted tests</h1>
<table id="sets" class="table table-striped table-bordered table-hover">

    <thead>
        <tr>
        <th>Test id</th>
        <th>Problem id</th>
        <th>Set id</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($zistujemodovzdane as $sada){
                echo "<tr><td>$sada[id_test]</td>";
                echo "<td>problem $sada[id_problem]</td>";
                echo "<td>sada $sada[id_set]</td></tr>";
            }
        ?>
    </tbody>

</table>
    
</body>
</html>