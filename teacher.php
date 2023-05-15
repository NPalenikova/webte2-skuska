<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$hostname = "localhost";
$username = "root";
$password = "password";
$dbname = "sadasad";
$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

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

function create_set($db, $name) {
    $stmt = $db->prepare('INSERT INTO set_problems (name) VALUES (:name);');
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    var_dump($name);
    $id = $db->lastInsertId();
    echo 'POST SUCCESSFUL';
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
    var_dump($data);
    echo 'POST SUCCESSFUL';
}