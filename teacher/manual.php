<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $displayValue = 'block';
    if($_SESSION["userType"] == 'student'){
        header("location: ../student/studentTesty.php");
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
    <title>Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

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
                <ul class="navbar-nav align-items-center ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="manual_sk.php">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                    <li class="nav-item me-3">
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


    <div class ="container-md my-3 py-3">
        <button class="btn btn-outline-secondary my-3" onclick="generatePDF()">Download as .pdf</button>
        <div id="manual">
            <h3>Teacher manual</h3>

            <p>Site <b>Sets</b> allows the teacher to define properties of sets taken from the directory <b>latex_subory</b>.<br>
            By clicking the <b>Update</b> button, the files from the directory are stored in the database.<br>
            After updating the files, a table is shown listing all of the files.<br>
            By checking the <b>Allowed</b> column, you choose from which files the problems from students are being generated.<br>
            By checking <b>Use Date</b>, you can define the time period in which students are allowed to generate problems from this file.<br>
            If you do not check <b>Use Date</b>, students will be allowed to generate problems from this file anytime.<br>
            If you check <b>Use Date</b> and only define the column <b>Date From</b>, the <b>Date To</b> will be automatically set to <b>9999-12-31</b>.<br>
            If you check <b>Use Date</b> and only define the column <b>Date To</b>, the <b>Date From</b> will be automatically set to <b>1000-01-01</b>.<br>
            If you check <b>Use Date</b> and don't define Date From and <b>Date To</b>, the dates will be automatically set to <b>1000-01-01</b> and <b>9999-12-31</b> respectively.<br>
            In this case, students will be allowed to generate problems from this file anytime.<br>
            By filling the <b>Points</b> column, you define the number of points that will be awarded for each problem generated from the given set.<br>
            You can save your changes by clicking the <b>Submit</b> button. <b>If you don't click the submit button, the data will be lost.</b><br>
            <b>If you update the files, all of the previous data is erased.</b><br><br>

            Site <b>Students</b> allows you to view what number of problems has a student submitted, how many were correct and how many points they achieved. <br>
            This table can be exported into a .csv file by clicking the <b>Download as csv</b> button. <br>
            Upon clicking on the row in table a <b>Detail</b> on the student will open. There you can see which tasks were generated for the student,
            if the task was submitted, if it was correct, the student's solution and the points scored for the given problem. <br> <br>
        
            On this page, upon clicking the <b>Download as pdf</b> button, these instructions will be generated into a pdf file. </p> 
        </div>
    </div>

    <script src="pdf.js"></script>
 </body>
 </html>