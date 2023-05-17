<?php
//$hostname = "localhost";
//$username = "root";
//$password = "password";
//$dbname = "sadasad";
require_once('../config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);



$query = "SELECT s.id, s.name, s.surname, SUM(CASE WHEN pc.check_problem = 1 THEN 1 ELSE 0 END) AS correct_problems_count, SUM(CASE WHEN pc.submitted = 1 THEN 1 ELSE 0 END) AS submitted_count, SUM(CASE WHEN pc.check_problem = 1 THEN sp.points ELSE 0 END) as earned_points, SUM(sp.points) as total_points
FROM student s
JOIN student_test st ON st.id_student = s.id
JOIN problem_check pc ON st.id_test = pc.id_test
JOIN problem p ON pc.id_problem = p.id
JOIN set_problems sp ON p.id_set = sp.id
GROUP BY s.id, s.name, s.surname, pc.id_test";
$stmt = $db->query($query);
$problems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="datatables.js"></script>

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
                        <a class="nav-link" href="teacher.php">Sets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Students</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="manual.html">Manual</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
<div class="container">
    <button id="csv" onclick="generateCSV()">Download as csv</button>
    <table id="students" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Student Id</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Submitted problems</th>
            <th>Correct problems</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($problems as $problem){
            echo '<tr onclick="studentDetail(' . $problem["id"] . ')"><td>' . $problem["id"] . '</td>
            <td>' . $problem["name"] . '</td>
            <td>' . $problem["surname"] . '</td>
            <td>' . $problem["submitted_count"] . '</td>
            <td>' . $problem["correct_problems_count"] . '</td>
            <td>' . $problem["earned_points"] . '/' . $problem["total_points"] .'</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    function studentDetail(id){
        window.location.href = "studentDetail.php?id=" + id;
    }
</script>
<script src="csv.js"></script>
</body>
</html>
