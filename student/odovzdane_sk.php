<?php

session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $displayValue = 'block';
    if($_SESSION["userType"] == 'teacher'){
        header("location: ../teacher/teacher.php");
    }
}
else{
    $displayValue = 'none';
    header("location: ../index.php");
}


require_once('../config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

$ziakIdPrihlaseny=  $_SESSION["id"];

$hladamSady =  "SELECT *  FROM student_test 
                INNER JOIN problem_check ON student_test.id_test = problem_check.id_test 
                INNER JOIN problem ON problem_check.id_problem = problem.id
                WHERE student_test.id_student = :idZiaka;";

$stmt = $db->prepare($hladamSady);
$stmt->bindParam(":idZiaka",$ziakIdPrihlaseny );
$stmt->execute();

$zistujemodovzdane = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odovzdané testy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="studentTesty_sk.php">Študentove testy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Odovzdané testy</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="odovzdane.php">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="btn btn-secondary" href="../logout_sk.php" style="display: <?php echo $displayValue; ?>">Odhlásiť sa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manual_sk.php">Návod</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>

<div class="container-md d-flex flex-column my-3 jistify-content-center">
    <h2 class="my-3">Odovzdané testy</h2>
    <table id="sets" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
            <th>Id testu</th>
            <th>Id príkladu</th>
            <th>Id sady</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($zistujemodovzdane as $sada){
                    echo "<tr><td>$sada[id_test]</td>";
                    echo "<td> $sada[id_problem]</td>";
                    echo "<td> $sada[id_set]</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>    
</body>
</html>