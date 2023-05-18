<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $displayValue = 'block';
        if($_SESSION["userType"] == 'student'){
            header("location: ../student/studentTesty_sk.php");
        }
    }
    else{
        $displayValue = 'none';
        header("location: ../index_sk.php");
    }

require_once('../config.php');

if (!isset($_GET['id'])) {
    exit("id not exist");
}
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT student.name, student.surname FROM student WHERE id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() === 0){
        header("location: students_sk.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

$query = "SELECT p.task, pc.check_problem, pc.submitted, pc.student_solution, CASE WHEN pc.check_problem = 1 THEN sp.points ELSE 0 END AS earned_points, sp.points as total_points FROM problem_check pc
	JOIN problem p ON p.id = pc.id_problem
    JOIN set_problems sp ON sp.id = p.id_set
    JOIN student_test st ON st.id_test = pc.id_test
    JOIN student s ON st.id_student = s.id
    WHERE s.id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['id']]);
$problems = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail študenta</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
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
                        <a class="nav-link" href="teacher_sk.php">Sady príkladov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="students_sk.php">Študenti</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
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
<div class="container">
    <div>
        <h1>Informácie o študentovi:</h1>
        <?php
         echo '<h2>' . $student["name"] . ' ' . $student["surname"] . '</h2>';
        ?>
    </div>
    <div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Príklad</th>
                    <th>Odovzdaný</th>
                    <th>Správny</th>
                    <th>Riešenie</th>
                    <th>Body</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($problems as $problem){
                    if ($problem["check_problem"] == 1){
                        $border = "style=\"background-color: #CEFFD0\"";
                        $correct = "áno";
                    } else if ($problem["check_problem"] == 0){
                        $border = "style=\"background-color: #FFAFAF\"";
                        $correct = "nie";
                    }
                    if ($problem["submitted"] == 1){
                        $submitted = "áno";
                    } else if ($problem["submitted"] == 0) {
                        $border = "";
                        $submitted = "nie";
                    }
                    echo '<tr ' . $border . '><td>'. $problem["task"] . '</td>
                <td>'. $submitted . '</td>
                <td>'. $correct . '</td>
                <td>'. $problem["student_solution"] . '</td>
                <td>'. $problem["earned_points"] . '/' . $problem["total_points"] . '</td><tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
