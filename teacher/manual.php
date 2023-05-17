<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $displayValue = 'block';
    if($_SESSION["userType"] == 'student'){
        header("location: ../student/stefanov.php");
    }
}
else{
    $displayValue = 'none';
    header("location: ../index.php");
}
?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="students.php">Students</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="../logout.php" style="display: <?php echo $displayValue; ?>">Log out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Manual</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
 <body>
    <div id="manual">
        Site <b>Sets</b> allows the teacher to define properties of sets taken from the directory <b>latex_subory</b>.<br>
        By clicking the <b>Update</b> button, the files from the directory are stored in the database.<br>
        After updating the files, a table is shown listing all of the files.<br>
        By checking the <b>Allowed</b> column, you choose from which files the problems from students are being generated.<br>
        By checking <b>Use Date</b>, you can define the time period in which students are allowed to generate problems from this file.<br>
        If you do not check <b>Use Date</b>, students won't be allowed to generate problems from this file.<br>
        If you check <b>Use Date</b> and only define the column <b>Date From</b>, the <b>Date To</b> will be automatically set to <b>9999-12-31</b>.<br>
        If you check <b>Use Date</b> and only define the column <b>Date To</b>, the <b>Date From</b> will be automatically set to <b>1000-01-01</b>.<br>
        If you check <b>Use Date</b> and don't define Date From and <b>Date To</b>, the dates will be automatically set to <b>1000-01-01</b> and <b>9999-12-31</b> respectively.<br>
        By filling the <b>Points</b> column, you define the number of points that will be awarded for each problem generated from the given set.<br>
        You can save your changes by clicking the <b>Submit</b> button. <b>If you don't click the submit button, the data will be lost.</b><br>
        <b>If you update the files, all of the previous data is erased.</b>
      </div>
 </body>
 </html>