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
                        <a class="nav-link" href="studentTesty.php">Student's Test</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
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
                        <a class="btn btn-secondary" href="../logout.php" style="display: <?php echo $displayValue; ?>">Logout</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link active" href="#">Manual</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class ="container-md my-3 py-3">
        <button id="download" class="btn btn-outline-secondary my-3" onclick="generatePDF()">Stiahnuť ako .pdf</button>
        <div id="manual">
            <p>Site <b>Student's test</b> allows the student to see which tests have been allowed by the teacher and with what rules.<br>
            By pressing the button in column <b>Test</b> you will see the problem generated from the selected set and a field for your solution. <br>
            By pressing the button <b>Close</b> you will close all of the generated problems.<br>
            
            You can enter your solution of the given problem into the <b>Solution</b> text field.<br>
            By pressing the <b>Submit button</b> you can submit your solution. <b> If you do not click Submit the data won't be saved.</b><br>

            On this page, upon clicking the <b>Download as pdf</b> button, these instructions will be generated into a pdf file. </p> 
        </div>
    </div>

    <script src="pdf.js"></script>
</body>
</html>