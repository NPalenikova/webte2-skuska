<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["userType"] == 'student'){
        header("location: ../index.php");
    }
    else{
        header("location: ../teacher/teacher.php");
    }
    exit;  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="signup.js"></script>
</head>
<body>
    <div class="d-flex justify-content-end container my-3 ">
        <div class="p-2">Already have an account?</div>
		<a class="btn btn-primary" href="../login/login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Login</a>
    </div>
    
    <form class="container my-3" name="signupForm" onsubmit="return validateForm()" method="post" action="process_signup.php" novalidate>
        <div class="my-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="my-3">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname">
        </div>

        <div class="my-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@stuba.sk" aria-describedby="emailHelpBlock">
            <div id="emailHelpBlock" class="form-text">
                Please enter a university email.
            </div>
        </div>

        <input type="hidden" id="userType" name="userType">

        <div class="my-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock">
            <div id="passwordHelpBlock" class="form-text">
                Please enter a password with 8-20 letters and/ or numbers.
            </div>
        </div>

        <div class="my-3">
            <label for="repeatPassword" class="form-label">Confirm password</label>
            <input type="password" id="repeatPassword" name="repeatPassword" class="form-control" aria-describedby="repeatPasswordHelpBlock">
            <div id="repeatPasswordHelpBlock" class="form-text">
                Please repeat the password.
            </div>
        </div>

        <button class="btn btn-primary my-3" type="submit" style="background-color: #072F5F; border-color:#072F5F;">Sign up</button>
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
