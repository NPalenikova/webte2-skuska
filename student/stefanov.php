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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.0.0/math.min.js"></script>


        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    </head>

<body>

<style>
    body {

        background-image: url('../resources/images/mrož.png');
        background-size: cover;
        background-repeat: no-repeat;
    }
</style>


<a href="../index.php">index</a>


<body  >
 
<div class="d-flex justify-content-center">
<h1>Výpis názvov .tex súborov</h1>
<div class= "text-left text-light bg-secondary opacity-75">

<ul id="fileList"></ul>


    <br>

    <div>
        <h2>z databazy:</h2>
        </div>
    <br>


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




        $hladamSady =  "SELECT *  FROM student_test 
             INNER JOIN problem_check ON student_test.id_test = problem_check.id_test 
             INNER JOIN problem ON problem_check.id_problem = problem.id
            WHERE student_test.id_student = :idZiaka;
             ";



        //$query7 =  "SELECT *  FROM problem WHERE id_set =:idZiaka";


        $stmt = $db->prepare($hladamSady);

        //TODO premenna zodpovedna za id studenta
        $ziakIdPrihlaseny = 1;

        echo '<script type="text/javascript"> var studentId = "' . $ziakIdPrihlaseny . '"; nastavStudentId(studentId);</script>';


        echo "<h2>Prihlaseny studentId: $ziakIdPrihlaseny </h2>";




        $stmt->bindParam(":idZiaka",$ziakIdPrihlaseny );

        $stmt->execute();


      //  $stmt = $db->query($hladamSady);


        $zistujemodovzdane = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "overujem studentove testy";
       foreach ($zistujemodovzdane as $sada){
            echo "<br>";
           //var_dump($sada);
           echo "<br>test $sada[id_test]";
           echo "<br>problem $sada[id_problem]";
           echo "<br>sada $sada[id_set]";

           //kazdy z testov by mal mat unikatny kod?
           //mam sadu

           //TODO podla id sady dokazem vylucit moznosti

       }

        //vyvorit array a ulozit ake sady uz naklikal?
        //spravit univerzalne pre akeholvek hraca todo

        echo "<h2 > finalizacia</h2>";

        $query6 =  "SELECT id, allowed , date_from , date_to, name  FROM set_problems";
        $stmt = $db->query($query6);
        $oversadu = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($sada);


        echo "<table>";

        $arraysad= array();
        foreach ($oversadu as $zjemosadu){
            array_push(  $arraysad, $zjemosadu['id']);
         //   $arraysad =


        }

       echo "<br> velkost array". sizeof($arraysad). " ";
        var_dump($arraysad);

        //vytvorim tlacidlo na reset?
        echo "<tr> <th> <button type='button' id='x' onclick='tlacidloOdozva( \"Hello, world!\", ".json_encode($arraysad) ." )'> x</button> </th>";


         foreach ($oversadu as $zjemosadu){


           // echo "<tr> <th> <button type='button' id='$zjemosadu[name]' onclick='tlacidloOdozva($zjemosadu[id] , $arraysad )'> $zjemosadu[name]</button> </th>";
            echo "<tr> <th> <button type='button' id='$zjemosadu[name]' onclick='tlacidloOdozva($zjemosadu[id] , ".json_encode($arraysad) ." )'> $zjemosadu[name]</button> </th>";
            //datum tam pridat
            echo "<th>od $zjemosadu[date_from] </th><th>do $zjemosadu[date_to] </th>";

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


                   echo "<br> <h2> Priklad: ". $priklady[$vybraty]['task']."</h2>";
                        //TODO este rozparsovat description a vytiahnut obrazok a
                        // vytiahnut vzorec - kod na to je, poprepajat
                        //vzrorec je vyznaceny $  na zaciatku a konci

                        //
                        // if (preg_match($pografiku, $uloha , $matches2)){
                        //
                        $pografiku='/(.*?)\\\includegraphics/s';

                    if (preg_match($pografiku, $priklady[$vybraty]['description'] , $zvastdescrition)){
                            //pripad ked mame aj obraz
                            //obraz aj vzorec
                            echo "<br>uprava: ".$zvastdescrition[1];
                            //este oddelit vzorce od textu a previest ich do normalneho tvaru

                             $oddelvzorce='/[$]/';
                            if ($dostan=preg_split($oddelvzorce, $zvastdescrition[1])){

                                $a=1;
                                //zacina nevzorcom takze ide to zisti podla toho ci je kladne alebo
                                //zaporne a
                                foreach ($dostan as $rozdelenie ){
                                   if (($a%2)==0){
                                       //echo "<br>".$a." vzorec: \begin{equation*} ".$rozdelenie. " \end{equation*}";
                                       echo " vzorec: \begin{equation*} ".$rozdelenie. " \\end{equation*}";
                                   }else{

                                       echo "<br>".$a." ".$rozdelenie;
                                   }

                                    $a++;


                                }
                            }

                        echo '<img src="../latex_subory/' .  $priklady[$vybraty]['picture_path'] . '" alt="Obrázok">';

                        echo "<br>id prikladu ".$priklady[$vybraty]['id'];
                        echo "<br>Solution ".$priklady[$vybraty]['solution'];

                        //TODO vytvorim skrite div co bude mat v sebe solution, id toho div bude v sebe mat cislo id sady?
                        //
                        //TODO nahrad s za x
                        echo "<div id='solution$sada[id]'>".$priklady[$vybraty]['solution']." </div>";
                        echo "<div id='priklad$sada[id]' style='display: none'>".$priklady[$vybraty]['id']." </div>";

                    }else{
                        //bez obrazu, iba vyberem zvorec odtial
                        echo "<br>nema g:".$priklady[$vybraty]['description'];
                    }




            }
            else{
                echo "<div> nema priklady!! </div>";

            }




            echo "</div>";

        }



        //zvoli ktoru sadu bude chciet

        //dam mu to vo foriem tlacidiel?

    ?>


    <div id="odpoved" style='display: none;'">
        <h2>Odpoved</h2>
    <textarea rows='2' cols='40' id="textodpoved"> </textarea>
    <button type='button' id="buttonodosli" onclick="odosliodpoved()">Click Me!</button>

   <script type="text/javascript">  dostanTextareaElement();</script>


</div>
    <h1 id="output">  </h1>
    <div ></div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


</div>

</div>

</body>







