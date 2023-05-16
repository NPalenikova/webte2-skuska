<?php
//$hostname = "localhost";
//$username = "root";
//$password = "password";
//$dbname = "sadasad";
require_once('config.php');
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function create_set($db, $name) {
    $stmt = $db->prepare('INSERT INTO set_problems (name) VALUES (:name);');
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $id = $db->lastInsertId();
    return $id;
}

function create_problem($db, $data) {
    $stmt = $db->prepare('INSERT INTO problem (task, solution, description, picture_path, id_set) VALUES (:task, :solution, :description, :picture_path, :id_set);');
    $stmt->bindParam(':task', $data['title']);
    $stmt->bindParam(':solution', $data['solution']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':picture_path', $data['imageSrc']);
    $stmt->bindParam(':id_set', $data['set_id']);
    $stmt->execute();
}

$query = "SELECT sp.id, sp.name, sp.allowed, sp.date_from, sp.date_to, sp.points, sp.id_teacher FROM set_problems sp";
$stmt = $db->query($query);
$set_problems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
    if (isset($_POST["update"])){
        $query = "DELETE FROM set_problems";
        $stmt = $db->query($query);
        $stmt->execute();

        $directory = 'latex_subory';
        $sectionRegex = '/\\\\section\*{(.+?)}([\\s\\S]*?)(?=\\\\section|$)/s';
        $descriptionRegex = '/\\\\begin{task}([\\s\\S]*?)\\\\end{task}|\\\\includegraphics/';
        $equationRegex = '/\\\\begin{equation\\*}([\\s\\S]*?)\\\\end{equation\\*}/';
        $imageRegex = '/\\\\includegraphics{(?:zadanie99\\/)?([^{}]+)}/';

        $fileContents = file_get_contents('latex_subory/odozva01pr.tex');
        $files = glob($directory . '/*.tex');
        foreach ($files as $file) {
            $filename = basename($file);
            $content = file_get_contents($file);
            $set_id = create_set($db, $filename);
            if (preg_match_all($sectionRegex, $content, $matches)) {
                foreach ($matches[0] as $i => $sectionMatch) {
                    $sectionTitle = $matches[1][$i];
                    $sectionContent = $matches[2][$i];

                    $equation = "";
                    if (preg_match($equationRegex, $sectionContent, $equationMatch)) {
                        $equation = trim($equationMatch[1]);
                    }

                    $imageSrc = "";
                    if (preg_match($imageRegex, $sectionContent, $imageMatch)) {
                        $imageSrc = trim($imageMatch[1]);
                    }

                    $description = "";
                    if (preg_match($descriptionRegex, $sectionContent, $descriptionMatch)) {
                        $description = trim($descriptionMatch[1]);
                    }
                    $section = [
                        'title' => $sectionTitle,
                        'solution' => $equation,
                        'imageSrc' => $imageSrc,
                        'description' => $description,
                        'set_id' => $set_id
                    ];
                    create_problem($db, $section);
                }
            }
        }
    }


    if(isset($_POST["id"])){
        $sql = 'UPDATE set_problems SET allowed = ?, date_from = ?, date_to = ?, points = ? WHERE id = ?';
        $stmt = $db->prepare($sql);
// Loop through the data array and execute the SQL statement for each row
        foreach ($_POST['id'] as $key => $id) {
            if (isset($_POST["allowed"])){
                if (in_array(strval($key), $_POST["allowed"])) {
                    $allowed = 1;
                } else {
                    $allowed = 0;
                }
            } else {
                $allowed = 0;
            }
            if (!empty($_POST['date_from'][$key])){
                $date_from = $_POST['date_from'][$key];
            } else {
                $date_from = "1000-01-01";
            }
            if (!empty($_POST['date_to'][$key])){
                $date_to = $_POST['date_to'][$key];
            } else {
                $date_to = "9999-12-31";
            }
            if (isset($_POST["useDate"])){
                if (!in_array(strval($key), $_POST["useDate"])) {
                    $date_from = null;
                    $date_to = null;
                }
            } else{
                $date_from = null;
                $date_to = null;
            }
            if (!empty($_POST['points'][$key])){
                $points = $_POST['points'][$key];
            } else{
                $points = null;
            }
            $stmt->execute([$allowed, $date_from, $date_to, $points, $id]);
        }
        $query = "SELECT sp.id, sp.name, sp.allowed, sp.date_from, sp.date_to, sp.points, sp.id_teacher FROM set_problems sp";
        $stmt = $db->query($query);
        $set_problems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>


<!DOCTYPE html>
<html>
<head>
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
                        <a class="nav-link active" aria-current="page" href="#">Sets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="students.php">Students</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
<div>
    <form action="#" method="post">
    <table id="sets" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Filename</th>
                <th>Allowed</th>
                <th>Use Date</th>
                <th>Date From</th>
                <th>Date to</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $counter = 0;
            foreach ($set_problems as $set){
                $checkedAllowed = "";
                $checkedDate = "";
                if ($set["allowed"] == 1){
                    $checkedAllowed = "checked";
                }
                if (isset($set["date_from"]) || isset($set["date_to"])){
                    $checkedDate = "checked";
                }
                echo '<tr><td>' .$set["name"] . '</td>';
                echo '<td class="hide"><input type="hidden" name="id[]" value="' . $set["id"]  . '"</td>';
                echo '<td><input type="checkbox" name="allowed[]" value="' . $counter . '" ' . $checkedAllowed . '></td>';
                echo '<td><input type="checkbox" name="useDate[]" value="' . $counter . '" ' . $checkedDate . '></td>';
                echo '<td><input type="date" name="date_from[]" value="' . $set["date_from"] . '"></td>';
                echo '<td><input type="date" name="date_to[]" value="' . $set["date_to"] . '"></td>';
                echo '<td><input type="number" name="points[]" value="' . $set["points"] . '"></td>';
                echo '</tr>';
                $counter++;
            }
        ?>
        </tbody>
    </table>
        <button type="submit">Submit</button>
    </form>
    <form action="#" method="post">
        <input type="hidden" name="update" value="yes">
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
