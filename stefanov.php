<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>

<style>
    body {
        background-image: url('resources/images/mrož.png');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>


<a href="index.php">spat na index</a>

<body  >

<div class="text-center">
<h1>Výpis názvov .tex súborov</h1>

<ul id="fileList"></ul>
    <?php


    $directory = 'latex_subory';
    $files = glob($directory . '/*.tex');

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $filename = basename($file);
        echo $filename . '<br>';
        echo "<pre>" . htmlspecialchars($content) . "</pre>";

    }
    ?>

</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>







