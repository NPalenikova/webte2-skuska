// Wait for MathJax and Math.js to load

//TODO kod nad zlato
window.onload = function() {
    // Define the LaTeX expressions to compare
   // var expression1 = "e^2";
   // var expression2 = "e*e";
     var expression1 = "e^2";
    var expression2 = "e*e";


    // Create a new element to render the expressions
    var output = document.getElementById("output");
    output.textContent
    // Render expressions using MathJax
    MathJax.tex2chtmlPromise(expression1).then(function(math1) {
        MathJax.tex2chtmlPromise(expression2).then(function(math2) {
            // Evaluate the expressions using Math.js
            var scope = { x: 2 }; // Set the value of x
            var value1 = math.evaluate(expression1, scope);
            var value2 = math.evaluate(expression2, scope);

            // Compare the evaluated values of the expressions
            var areEqual = value1 === value2;

            // Display the result
            output.textContent = "Expressions are " + (areEqual ? "equal" : "not equal");
        });
    });
};


function porovnajVzorce(expression1,expression2 ){
    // Define the LaTeX expressions to compare
  //  var expression1 = "e^2";
  //  var expression2 = "e*e";


    // Create a new element to render the expressions
    var output = document.getElementById("output");
    output.textContent
    // Render expressions using MathJax
    MathJax.tex2chtmlPromise(expression1).then(function(math1) {
        MathJax.tex2chtmlPromise(expression2).then(function(math2) {
            // Evaluate the expressions using Math.js
            var scope = { x: 2 }; // Set the value of x
            var value1 = math.evaluate(expression1, scope);
            var value2 = math.evaluate(expression2, scope);

            // Compare the evaluated values of the expressions
            var areEqual = value1 === value2;

            // Display the result

            output.textContent = "Expressions are " + (areEqual ? "equal" : "not equal");
            return areEqual;


        });
    });
};



function convertLatexToRaw(latexExpression) {
    var rawExpression = latexExpression.replace(/\\dfrac{([^{}]+)}{([^{}]+)}/g, '$1/$2');
    rawExpression = rawExpression.replace(/\\([^\\{}]+)(?:{([^{}]+)})?/g, function(match, command, argument) {
        switch (command) {
            case 'dfrac':
                return '';
            case 'sqrt':
                return 'sqrt{' + argument + '}';
            // Add more cases for other LaTeX commands as needed
        }
        // Return the original match if no conversion is found
        return match;
    });

    return rawExpression;
}



// Example usage
//var latexExpression = '\\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15} + \\sqrt{5}';
//var rawExpression = convertLatexToRaw(latexExpression);
//console.log("zz "+rawExpression); // Output: 1/2 + sqrt{3}

//pomocou tochto id znova najdem solution
sadaid ="";
//var textodpoved = document.getElementById("textodpoved");

 textodpoved="";

function dostanTextareaElement(){

    textodpoved = document.getElementById("textodpoved");
    console.log("zober obsah "+textodpoved.value);
}

//poslat aktualneho
function tlacidloOdozva(uloha , zoznamid){
    // skryje ostatne
    // svoj odokryje

   // display = inline
    //za kazde id co zoberem tak schovam
    zoznamid.forEach(function (jednoId){
        //console.log("id? "+jednoId);
       var zakryIdDiv = document.getElementById("uloha"+jednoId);
       zakryIdDiv.style.display ="none";


    });
    //var textodpoved = document.getElementById("textodpoved");
    //var buttonodosli = document.getElementById("textodosli");
    var odpoveddiv = document.getElementById("odpoved");
    if (typeof uloha ==="string"){
       // console.log("zakri tlacidlo stlacene");
     odpoveddiv.style.display = "none"

    }else {
        var skrytyDiv = document.getElementById("uloha"+uloha);
        textodpoved.value ="";
        sadaid =uloha;
        skrytyDiv.style.display = "inline";
        //textodpoved
        //textodosli
        odpoveddiv.style.display = "inline";
       // textodpoved.style.display="inline";
      //  buttonodosli.style.display= "inline";
    }

}


studentId="";


function nastavStudentId(nastav){
    studentId =nastav;
   // console.log("studentove id "+ studentId);
}

rozkliknutyPriklad =null;

function prikladZakliknuty(nastav){
    rozkliknutyPriklad =nastav;

}


function resetOverenia(){
    output.textContent = "";
}

function odosliodpoved(){

  //  console.log(textodpoved.value);
    //var ziakovaOdpoved=
  //  console.log("id sady kde je priklad"+ sadaid);
   // console.log("solution "+document.getElementById("solution"+sadaid).innerText);
   // console.log("solution "+document.getElementById("solution"+ulozid).innerHTML);
    //dam porovnat odpoved a solution
    //TODO do tochto dostat solution
    //solution mam, mam oboje
    //TODO solution konvertovat do normalneho stavu

    rawvzorec = convertLatexToRaw(document.getElementById("solution"+sadaid).innerText);
 //   console.log("Raw vzorec "+  rawvzorec);
    //porovnat ci su rovnake?
//.replace(/s/g, "x");
  //  console.log("prehod x/s "+rawvzorec.replace(/s/g, "x") );
    console.log(" "+rawvzorec.replace(/s/g, "x") );
  //  console.log(textodpoved.value.replace(/[A-Za-z](?=[A-Za-z])/g, "$&*"));

  //  console.log( "textare prevedeny "+textodpoved.value.replace(/[A-DF-Za-df-z]/g, "x").replace(/[A-Za-z](?=[A-Za-z])/g, "$&*"))

    porovnanie=  porovnajVzorce( rawvzorec.replace(/[A-DF-Za-df-z]/g, "x") ,textodpoved.value.replace(/[A-DF-Za-df-z]/g, "x").replace(/[A-Za-z](?=[A-Za-z])/g, "$&*")  );





    //console.log("zbieranie dat");
    //studentve idcko
   // console.log("studentove id "+ studentId);

    //TODO id prikladu
    //id sady???
     idprikladu=  document.getElementById("priklad"+sadaid);

   // console.log("id prikladu "+ idprikladu.innerText);


    //check_problem
    //porovnanie
   // console.log("porovnanie "+porovnanie);




  //  console.log("zadany text "+textodpoved.innerText);


        //TODO poslat vsetky data co mam naspat do databazy

    console.log("studentid "+studentId);
    console.log("idprikladu "+idprikladu.innerText);
    console.log("sadaid "+sadaid);
  //  console.log("porovnanie "+porovnanie);
    if (porovnanie){
        console.log("porovnanie true");
    } else if(!porovnanie) {
        console.log("porovnanie false");
    }else{
        console.log("porovnanie undefined");
    }
    console.log("textodpoved "+textodpoved.value);


    /*
 var data = "<data>";
 data += "<item><studentid>"+studentId+"</studentid><idprikladu>"+idprikladu.innerText+"</idprikladu><sadaid>"+sadaid+"</sadaid><porovnanie>"+porovnanie+"</porovnanie><textodpoved>"+textodpoved.value+"</textodpoved></item>";
 data += "</data>";*/

    var xhr = new XMLHttpRequest();
    var url = "odosliProblem_check.php";
 //   var url = "../test.php";

if (porovnanie){
    var data = "ziakID="+ encodeURIComponent(studentId)+ "&prikladID="+encodeURIComponent(idprikladu.innerText)
        +"&sadaID="+encodeURIComponent(sadaid)+"&check_problem="+encodeURIComponent(1)+"&student_solution="+encodeURIComponent(textodpoved.value);
}else   {
    var data = "ziakID="+ encodeURIComponent(studentId)+ "&prikladID="+encodeURIComponent(idprikladu.innerText)
        +"&sadaID="+encodeURIComponent(sadaid)+"&check_problem="+encodeURIComponent(0)+"&student_solution="+encodeURIComponent(textodpoved.value);
}



    xhr.open("POST", url, true);
  //  xhr.setRequestHeader("Content-type", "text/xml");

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Spracovanie odpovede od servera
            console.log(xhr.responseText);
        }
    };

    xhr.send(data);



     /* var data = "ziakID="+ encodeURIComponent(studentId)+ "&prikladID="+encodeURIComponent(idprikladu)
          +"&sadaID="+encodeURIComponent(sadaid)+"&check_problem="+encodeURIComponent(porovnanie)+"&student_solution="+encodeURIComponent(textodpoved.innerText);
*/




    /*

      var xhr = new XMLHttpRequest();

 
      //TODO inu adresu, aby vedel posielat

      //xhr.open("POST", " https://site88.webte.fei.stuba.sk/skuska/odosliProblem_check.php");
      xhr.open("POST", "odosliProblem_check.php",true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
*/
      /*
      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
              console.log("xhr status "+ xhr.status);
              console.log("xhr response " +xhr.responseText);
              xhr.send(data);
          }
      };*/
 /*   xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
           // console.log("Data inserted successfully.");
        }
    };
    xhr.send(data);*/

}