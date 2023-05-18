<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'student'){
        header("location: ../student/studentTesty_sk.php");
    }
    else{
        header("location: ../teacher/teacher_sk.php");
    } 
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrácia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="signup_sk.js"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="d-flex justify-content-end container my-3 ">
        <div class="p-2">Už máte účet?</div>
		<a class="btn btn-primary" href="../login/login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Prihlásiť sa</a>
    </div>
    
    <form class="container my-3" name="signupForm" onsubmit="return validateForm()" method="post" action="process_signup_sk.php" novalidate>
        <div class="my-3">
            <label for="name" class="form-label">Meno</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="my-3">
            <label for="surname" class="form-label">Priezvisko</label>
            <input type="text" class="form-control" id="surname" name="surname">
        </div>

        <div class="my-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@stuba.sk" aria-describedby="emailHelpBlock">
            <div id="emailHelpBlock" class="form-text">
                Prosím zadajte univerzitný email.
            </div>
        </div>

        <input type="hidden" id="userType" name="userType">

        <div class="my-3">
            <label for="password" class="form-label">Heslo</label>
            <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock">
            <div id="passwordHelpBlock" class="form-text">
                Prosím zadajte heslo, ktoré obsahuje 8-20 písmen a/alebo písmen.
            </div>
        </div>

        <div class="my-3">
            <label for="repeatPassword" class="form-label">Zopakujte heslo</label>
            <input type="password" id="repeatPassword" name="repeatPassword" class="form-control" aria-describedby="repeatPasswordHelpBlock">
            <div id="repeatPasswordHelpBlock" class="form-text">
                Prosím zopakujte heslo.
            </div>
        </div>

        <button class="btn btn-primary my-3" type="submit" style="background-color: #072F5F; border-color:#072F5F;">Zaregistrovať sa</button>
    </form>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="myToast" class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body"></div>
        </div>
    </div>
</body>
</html>
