<!DOCTYPE html>
<html>

<head>
    <?php if (!isset($_POST['tipo'])) {
        include '../html/Head.html';
    }
    ?>
</head>

<body>
    <?php
    if (isset($_POST['mail'])) {
        $correoaqui = $_POST['mail'];
        if (!isset($_POST['tipo'])) {
            include '../php/Menus.php';
        }
    } else {
        echo 'No tienes permiso para estar aqui';
        include '../php/Menus.php';
        die();
    } ?>
    <section class="main" id="s1">
        <?php
        //Esto va a realizar la insercción en la base de datos de la pregunta.
        //Primero cogeremos los valores del formulario via POST.
        $enunciado = $_POST['enunciado'];
        $correo = $_POST['correo'];
        $correcta = $_POST['correcta'];
        $incor1 = $_POST['inc1'];
        $incor2 = $_POST['inc2'];
        $incor3 = $_POST['inc3'];
        $complejidad = $_POST['complej'];
        $tema = $_POST['tema'];

        //Ahora vamos a abrir una sesion con mysqli:
        $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
        if (!$mysqli) {
            die("Hay algo raro que esta fallando con MySQL" . mysql_connect_error());
        }

        $error = validar($correo, $enunciado, $correcta, $incor1, $incor2, $incor3, $tema, $complejidad);
        if ($error == '') {
            $sql = "INSERT INTO preguntas(correo,enunciado,correcto,incor1,incor2,incor3,tema,complejidad) VALUES ('$correo','$enunciado','$correcta','$incor1','$incor2','$incor3','$tema','$complejidad')";
            //Ahora insertamos a la base de datos los datos de la pregunta
            if (mysqli_query($mysqli, $sql)) {

                echo "<div>
                        La pregunta ha sido añadida correctamente a la BD
                    </div>";

                //anadir nuevo elemento assessmentitem a Questions.xml
                $questionsFile = '../xml/Questions.xml';
                if (file_exists($questionsFile)) {
                    $xml = simplexml_load_file($questionsFile);
                }

                if ($xml) {
                    $assessmentItem = $xml->addChild('assessmentItem');
                    $assessmentItem->addAttribute('subject', $tema);
                    $assessmentItem->addAttribute('author', $correo);

                    $itemBody = $assessmentItem->addChild('itemBody');
                    $p = $itemBody->addChild('p', $enunciado);

                    $correctResponse = $assessmentItem->addChild('correctResponse');
                    $correctResponse->addChild('response', $correcta);

                    $incorrectResponses = $assessmentItem->addChild('incorrectResponses');
                    $incorrectResponse = $incorrectResponses->addChild('response', $incor1);
                    $incorrectResponse = $incorrectResponses->addChild('response', $incor2);
                    $incorrectResponse = $incorrectResponses->addChild('response', $incor3);

                    $xml->asXML();
                    $xml->asXML('../xml/Questions.xml');
                    echo "
        <div>
          La pregunta ha sido añadida correctamente al fichero XML
        </div>";
                } else {
                    echo "
        <div>
          Ha ocurrido un error al añadir la pregunta al fichero XML
        </div>";
                }

                echo "<a href='ShowQuestions.php?mail=" . $correoaqui . "'> Ver pregunta</a>";
            } else {
                echo '' . mysqli_error($mysqli) . '';
            }
        } else {
            echo ("<script> 
        alert('$error');
        document.location.href = 'QuestionFormWithImage.php';
      </script>");
        }


        //Ahora cerramos la conexion con la base de datos
        mysqli_close($mysqli);

        //validacion del formulario
        function validar($correo, $enunciado, $correcta, $incor1, $incor2, $incor3, $tema, $complejidad)
        {
            $error = '';
            if ($correo == '') {
                $error = 'Es obligatorio introducir una dirección de correo';
            } else if (!preg_match("/^[a-z]+[0-9]{3}(@ikasle.ehu.)(eus|es)$/", $correo) && (!preg_match("/^[a-z]+([\.-]{1}[a-z]+)?(@ehu.)(eus|es)$/", $correo))) {
                $error = 'La dirección de correo introducida no es válida';
            } else if (strlen($enunciado) < 10) {
                $error = 'Enunciado no valido!';
            } else if ($correcta == '' || $incor1 == '' || $incor2 == '' || $incor3 == '') {
                $error = 'Es obligatorio introducir las cuatro respuestas posibles';
            } else if ($complejidad != 1 && $complejidad != 2 && $complejidad != 3) {
                $error = 'Complejidad incorrecta';
            } else if ($tema == '') {
                $error = 'Introduce un tema';
            }
            return $error;
        }
        ?>
    </section>
    <?php include '../html/Footer.html' ?>
</body>

</html>