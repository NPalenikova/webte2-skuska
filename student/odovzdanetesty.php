
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">




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

//TODO studentove testy


echo "<h1>Prehlad testov</h1>";

echo "<table id='sets' class='table table-striped table-bordered table-hover'>";
echo '  <thead>
            <tr>
                <th>id test</th>
                <th>id problem</th>
                <th>id sada</th>
                
                
            </tr>
            </thead>';


foreach ($zistujemodovzdane as $sada){


    //var_dump($sada);
    echo " <tr><th>test $sada[id_test]</th>";
    echo "<th>problem $sada[id_problem]</th>";
    echo "<th>sada $sada[id_set]</th>";
   // echo "</div>";
}
echo "</table>";