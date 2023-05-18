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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Študentove testy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.0.0/math.min.js"></script>


        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

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
                        <a class="nav-link active" href="#">Študentove testy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="odovzdane_sk.php">Odovzdané testy</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">
                            <img src="../resources/images/sk.png" alt="sk-flag" width="40" height="27">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="studentTesty.php">
                            <img src="../resources/images/uk.png" alt="uk-flag" width="40" height="20">
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="btn btn-secondary" href="../logout_sk.php" style="display: <?php echo $displayValue; ?>">Odhlásiť sa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manual_sk.php">Návod</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>

<!-- mroz gone
<style>
    body {

        background-image: url('../resources/images/mrož.png');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>
-->



<body  >
 
<div class="d-flex justify-content-center">

<div class= " text-dark opacity-100 w-75 ps-5 pe-5 vh-100 ">

<ul id="fileList"></ul>





    <script src="kodNaPorovnanie.js"></script>

    <?php



    require_once ('../config.php');
        try {
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT description , solution  FROM problem";
            $stmt = $db->query($query);
            $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);


        } catch (PDOException $e) {
            echo $e->getMessage();
        }



        //TODO overit ci nepouzil daky z testov
        //bude uz prihlaseny jeden zo studentov,
        //zoberem jeho vykonane odpovede
        // a provnam to s testami ci maju rovnake id
        //Od ziaka dostanem id to porovnam v tabulke id testu a ten porovnam s problem check
        //v problem check uz konecne najdem aku sadu vyplnil



        $ziakMeno = $_SESSION["fullname"];
        $ziakIdPrihlaseny=  $_SESSION["id"];
       //test ziaka s danym id
      //  $ziakIdPrihlaseny=  1;

        echo '<script type="text/javascript"> var studentId = "' . $ziakIdPrihlaseny . '"; nastavStudentId(studentId);</script>';


        echo "<h2 class='my-4'>Prihlásený: $ziakMeno   </h2>";

        $hladamSady =  "SELECT *  FROM student_test 
                 INNER JOIN problem_check ON student_test.id_test = problem_check.id_test 
                 INNER JOIN problem ON problem_check.id_problem = problem.id
                WHERE student_test.id_student = :idZiaka;
                 ";
        $stmt = $db->prepare($hladamSady);
        $stmt->bindParam(":idZiaka",$ziakIdPrihlaseny );

        $stmt->execute();



        $zistujemodovzdane = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //TODO studentove testy

           /* echo "overujem studentove testy";

       foreach ($zistujemodovzdane as $sada){
            echo "<br>";
           //var_dump($sada);
           echo "<br>test $sada[id_test]";
           echo "<br>problem $sada[id_problem]";
           echo "<br>sada $sada[id_set]";
       }*/

           //kazdy z testov by mal mat unikatny kod?
           //mam sadu

           //TODO podla id sady dokazem vylucit moznosti





        $query6 =  "SELECT id, allowed , date_from , date_to, name  FROM set_problems WHERE set_problems.allowed =1";
        $stmt = $db->query($query6);
        $oversadu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($sada);


        //id="sets" class="table table-striped table-bordered table-hover"


        $arraysad= array();
        foreach ($oversadu as $zjemosadu){
            array_push(  $arraysad, $zjemosadu['id']);
         //   $arraysad =


        }

        echo " <button type='button' id='x' onclick='tlacidloOdozva( \"Hello, world!\", ".json_encode($arraysad) ."  )' class='btn btn-outline-dark my-2'> Naspäť</button> ";
       // echo "<tr> <th> <button type='button' id='x' onclick='tlacidloOdozva( \"Hello, world!\", ".json_encode($arraysad) ."  )' class='btn btn-outline-dark'> x</button> </th>";
        echo "<table id='sets' class='table table-striped table-bordered table-hover'>";
            echo '  <thead>
            <tr>
                <th>Test</th>
                <th>Dátum od</th>
                <th>Dátum do</th>
                
                
            </tr>
            </thead>';

         foreach ($oversadu as $zjemosadu){


             echo "<tr> <th> <button type='button' id='$zjemosadu[name]' onclick='tlacidloOdozva($zjemosadu[id] , ".json_encode($arraysad) ." )' class='btn btn-outline-dark'> $zjemosadu[name]</button> </th>";

            //datum tam pridat
            echo "<th> $zjemosadu[date_from] </th><th> $zjemosadu[date_to] </th>";

            echo "</tr>";


        }
        echo "</table>";


        //do funkcie poslat vsetky nazvy a spravit ich funkcne, alebo urobit funkciu co zobere svoj nazov co zavolal?

        foreach ($oversadu as $zjemosadu){
            platnePriklady($zjemosadu ,$db);
        }



        function platnePriklady($sada, $db){

            //vytvorit divko s id? , vytvori aj ked neni priklad
            echo "<div id='uloha$sada[id]'  style='display: none;'>";

            $query7 =  "SELECT *  FROM problem WHERE id_set =:idSada";


            $stmt = $db->prepare($query7);

            $stmt->bindParam(":idSada",$sada['id'] );

            $stmt->execute();



            $priklady = $stmt->fetchAll(PDO::FETCH_ASSOC);


            //     echo "<br>velkost". sizeof($priklady);

            if (sizeof($priklady)>0){

                $vybraty =  rand( 0,  sizeof($priklady)-1); //tuna vybere priklad


                   echo "<br> <h2> Príklad: ". $priklady[$vybraty]['task']."</h2>";
                        //TODO este rozparsovat description a vytiahnut obrazok a
                        // vytiahnut vzorec - kod na to je, poprepajat
                        //vzrorec je vyznaceny $  na zaciatku a konci

                        //
                        // if (preg_match($pografiku, $uloha , $matches2)){
                        //
                        $pografiku='/(.*?)\\\includegraphics/s';

                        if (preg_match($pografiku, $priklady[$vybraty]['description'] , $zvastdescrition)){

                                 $oddelvzorce='/[$]/';
                                if ($dostan=preg_split($oddelvzorce, $zvastdescrition[1])){

                                    $a=1;
                                    //zacina nevzorcom takze ide to zisti podla toho ci je kladne alebo
                                    //zaporne a

                                    echo "<div>";
                                    foreach ($dostan as $rozdelenie ){
                                       if (($a%2)==0){
                                           //echo "<br>".$a." vzorec: \begin{equation*} ".$rozdelenie. " \end{equation*}";


                                           echo "<div class='d-inline-flex p-2'> \begin{equation*} ".$rozdelenie. " \\end{equation*}</div>>";
                                       }else{

                                           echo "<div class='d-inline-flex p-2'> ".$rozdelenie. "</div>";
                                       }

                                        $a++;
                                    }
                                    echo "</div>";


                                }

                            echo '<img  src="../latex_subory/' .  $priklady[$vybraty]['picture_path'] . '" alt="Obrázok"  class = "img-responsive img-thumbnail">';

                         //   echo "<br>id prikladu ".$priklady[$vybraty]['id'];
                           // echo "<br>Solution ".$priklady[$vybraty]['solution'];


                        }else{
                            //bez obrazu, iba vyberem zvorec odtial, ps. nebol testovany
                            //echo "<br>nema g:".$priklady[$vybraty]['description'];

                            $oddelvzorce='/[$]/';
                            if ($dostan=preg_split($oddelvzorce, $zvastdescrition[1])){

                                $a=1;
                                //zacina nevzorcom takze ide to zisti podla toho ci je kladne alebo
                                //zaporne a

                                echo "<div>";
                                foreach ($dostan as $rozdelenie ){
                                    if (($a%2)==0){

                                        echo "<div class='d-inline-flex p-2'> \begin{equation*} ".$rozdelenie. " \\end{equation*}</div>>";
                                    }else{

                                        echo "<div class='d-inline-flex p-2'> ".$rozdelenie. "</div>";
                                    }

                                    $a++;
                                }
                                echo "</div>";


                            }



                        }

                //nevymazavat tieto divy, obsahuju v sebe info co zbiera js
                echo "<div id='solution$sada[id]' style='display: none'>".$priklady[$vybraty]['solution']." </div>";
                echo "<div id='priklad$sada[id]' style='display: none'>".$priklady[$vybraty]['id']." </div>";




            }
            else{
                echo "<div> nema priklady!! </div>";

            }




            echo "</div>";

        }



        //zvoli ktoru sadu bude chciet

        //dam mu to vo foriem tlacidiel?

    ?>

    <div id="odpoved" style="display: none;" >


    <div  class="d-flex flex-column my-2 "  >

        <h2>Odpoveď</h2>
    <textarea class="my-2 " rows='2' cols='40' id="textodpoved">test ma udaje</textarea>


    <button type='button' id="buttonodosli" onclick="odosliodpoved()" class='btn btn-outline-dark mb-5'>Odoslať</button>

        <script type="text/javascript">  dostanTextareaElement();</script>

        <h1 id="output" >  </h1>




    </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!--     <script type="text/javascript">  resetOverenia();</script> -->

</div>

</div>

</body>







