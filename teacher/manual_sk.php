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
                        <a class="nav-link" href="teacher.php">Sady príkladov</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="students.php">Študenti</a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center ms-auto">
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
                    <li class="nav-item me-3">
                        <a class="btn btn-secondary" href="../logout_sk.php" style="display: <?php echo $displayValue; ?>">Odhlásiť sa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Návod</a>
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
            <h3>Návod pre učiteľa</h3>
 
            <p>Stránka <b>Sady príkladov</b> umožňuje učiteľovi definovať pravidlá pre sady príkladov šťahované z priečinku <b>latex_subory</b>.<br>
            Po kliknutí na tlačidlo <b>Aktualizovať</b> sa súbory stiahnu z priečinku a sú uložené do databázy.<br>
            Po aktualizácii sa zobrazí tabuľka, ktorá obsahuje všetky súbory a dovoľuje nastaviť ich pravidlá.<br>
            Zaškrknutím políčka v stĺpci <b>Povolené</b> vyberiete, z ktorých súborov môžu študenti generovať príklady.<br>
            Zaškrknutím políčka v stĺpci <b>Určiť dátum</b> môžete zadefinovať v akom časovom období môžu študenti generovať príklady z tejto sady.<br>
            Ak nezaškrtnete políčko <b>Určiť dátum</b>, študenti budú môcť generovať príklady z tejto sady kedykoľvek.<br>
            Ak zaškrtnete políčko <b>Určiť dátum</b> a určíte iba <b>Dátum od</b>, <b>Dátum do</b> sa automaticky nastaví na <b>9999-12-31</b>.<br>
            Ak zaškrtnete políčko <b>Určiť dátum</b> a určíte iba <b>Dátum do</b>, <b>Dátum od</b> sa automaticky nastaví na <b>1000-01-01</b>.<br>
            Ak zaškrtnete políčko <b>Určiť dátum</b> a neurčíte <b>Dátum od</b> ani <b>Dátum do</b>, dátumy sa automaticky nastavia na <b>1000-01-01</b> a <b>9999-12-31</b>.<br>
            V tomto prípade si takisto študenti budú môcť generovať príklady z tejto sady kedykoľvek. <br>
            Vyplnením políčka <b>Body</b>, zadefinujete počet bodov, ktorý bude udelený za každý príklad z danej sady.<br>
            Zmeny uložíte kliknutím na tlačidlo <b>Potvrdiť</b>. <b> Ak nekliknete na talčidlo Potvrdiť, dáta nebudú uložené.</b><br>
            <b>Pri Aktualizovaní súborov sú všetky predchádzajúce dáta vymazané.</b></p>

            <p>Stránka <b>Študenti</b> umožňuje prezerať koľko príkladov študent odovzdal, koľko bolo správnych a koľko za ne získal bodov.<br>
            Túto tabuľku môžete exportovať do .csv súboru kliknutím na tlačidlo <b>Stiahnuť ako .csv</b>. <br>
            Po kliknutí na riadok v tabuľke sa zobrazí <b>Detail</b> študenta. Následne uvidíte, ktoré príklady si študent vygeneroval, 
            či boli odovzdané, či boli správne, študentovo riešenie a získané body za daný príklad.</p>

            <p>Na tejto stránke je možné stiahnuť tento návod ako .pdf súbor po kliknutí na tlačidlo <b>Stiahnuť ako .pdf</b>.</p> 
        </div>
    </div>

    <script src="pdf.js"></script>
 </body>
 </html>