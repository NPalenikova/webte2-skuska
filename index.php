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
<body>

    <div id="flags">
        <i class="flag flag-slovakia"></i>
        <i class="flag flag-united-kingdom"></i>
    </div>
    <?php
        session_start();

        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            echo 
            '<div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-secondary" href="logout.php" role="button" style="position: absolute; top: 0; right: 0; margin: 10px;">Log out</a>
                    </div>
                </div>
            </div>'; 
        }
        else{
            echo
            '<div class="container my-5">
                <a class="btn btn-primary" href="login/login.php" role="button" style="background-color: #1261A0; border-color:#1261A0;">Login</a>
                <a class="btn btn-primary" href="signup/signup.php" role="button" style="background-color: #072F5F; border-color:#072F5F;">Sign up</a>
            </div>';
        }
    ?>
</body>
</html>
