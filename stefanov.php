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

<div class="d-flex justify-content-center">
<h1>Výpis názvov .tex súborov</h1>
<div class= "text-left text-light bg-secondary opacity-75">

<ul id="fileList"></ul>
    <?php


    $directory = 'latex_subory';
    $files = glob($directory . '/*.tex');

    $pattern1 = '/\\\begin\{task\}(.*?)\\\end\{task\}/s';
    $pattern2 = '/\\\begin\{solution\}(.*?)\\\end\{solution\}/s';

    $pattern3 = '/\\\\begin{equation\*}(.*?)\\\\end{equation\*}/s';
    echo "neni z databazy :(";

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $filename = basename($file);
        echo  '<h2>'. $filename . '</h2><br>';

        //TODO toto je pre cely subor
     //   echo "<pre>" . htmlspecialchars($content) . "</pre>";


        //toto len vyberem danu cast
        if (preg_match($pattern1, $content, $matches)) {
        // Obsah sa nachádza v $matches[1]
        $uloha = $matches[1];
            echo "<br>Uloha: <br>";
        // Vypíšte obsah riešenia
            echo $uloha;

        }
        if (preg_match($pattern3, $content, $matches)) {
            // Obsah sa nachádza v $matches[1]
            $solution = $matches[1];

            echo "<br><br> Solution:<br>";
            // Vypíšte obsah riešenia
            echo $solution;

        }else{
            echo "<br> nenaslo cast so solution";
        }

      //  break;

    }
    ?>

</div>
    <h2>Je tu predcasny break</h2>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>







