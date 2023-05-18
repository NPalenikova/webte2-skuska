<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $displayValue = 'block';
    if($_SESSION["userType"] == 'teacher'){
        header("location: ../teacher/teacher_sk.php");
    }
}
else{
    $displayValue = 'none';
    header("location: ../index_sk.php");
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Návod</title>
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
                        <a class="nav-link" href="studentTesty_sk.php">Študentove testy</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="manual.php">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="../logout_sk.php" style="display: <?php echo $displayValue; ?>">Odhlásiť sa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Návod</a>
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
            <h3>Návod pre študenta</h3>
 
            <p>Stránka <b>Študentove testy</b> umožňuje študentovi prezerať, ktoré testy boli učiteľom zverejnené a s akými pravidlami.<br>
            Kliknutím na tlačidlo v stĺpci <b>Test</b> sa otvorí vygenerovaný príklad a zobrazí sa políčko pre odpoveď. <br>
            Po kliknutí na tlačidlo <b>Naspäť</b> sa zatvoria aktuálne otvorené príklady.<br>
            
            Vyplnením políčka <b>Odpoveď</b> zadáte svoje riešnie daného príkladu.<br>
            Zmeny uložíte kliknutím na tlačidlo <b>Odoslať</b>. <b> Ak nekliknete na talčidlo Potvrdiť, dáta nebudú uložené.</b><br>

            <p>Na tejto stránke je možné stiahnuť tento návod ako .pdf súbor po kliknutí na tlačidlo <b>Stiahnuť ako .pdf</b>.</p> 
        </div>
    </div>

    <script src="pdf.js"></script>
</body>
</html>