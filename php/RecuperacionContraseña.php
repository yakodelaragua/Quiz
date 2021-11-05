<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<?php
    include '../html/Head.html';
?>
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1">
    <h2>¿Tienes problemas para acceder?</h2><br>
    <h4>Introduce tu nombre y correo electronico para obtener un codigo de verificacion</h4><br>

    <form name="contra" action="RecuperacionContraseña.php" method="POST">
        Nombre:* <input type="text" id="nombre" name="nombre" required><br><br>

        Email:* <input type="text" id="email" name="email" required><br><br>

    <div>
        <button type="submit" class= "boton-3d" name="submit">Continuar</button>
    </div>
    </form>

    <?php
    if(isset($_POST['email'])&& strlen($_POST['email'])!=0){
    $email=$_POST['email'];    
    //Ahora vamos a abrir una sesion con mysqli:
    $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");

    if(!$mysqli){
        die("Hay algo raro que esta fallando con MySQL". mysql_connect_error());
    }
    $result = mysqli_query($mysqli,"select * from usuarios where email ='$email' LIMIT 1");
    $cont = mysqli_num_rows($result); 
    if($cont == 0) {
        echo ("No se ha podido encontrar tu cuenta de Quiz");
    } else {
        if(isset($_POST['submit'])){
            require '../lib/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';
            $mail->Username='help.quizeljuego@gmail.com';
            $mail->Password='quizhelp0';
            
            $mail->setFrom($_POST['email'], $_POST['nombre']);
            $mail->addAddress($_POST['email']);
            $mail->addReplyTo($_POST['email'], $_POST['nombre']);

            $mail->isHTML(true);
            $mail->Subject='QUIZ: Recupera tu cuenta';
            
            $codigo=rand(100000, 999999);
            $mail->Body='<h2 align=left>Hola '.$_POST['nombre'].'('.$_POST['email'].')<br>Introduce el siguiente codigo para recuperar tu cuenta<br><br></h2> <h1 align=center> Codigo de recuperacion: '.$codigo.'</h1>';

            if(!$mail->send()) {
                echo "Ha ocurrido un error, intentalo de nuevo";
            } else {
                $_SESSION["Recuperando"]="SI";
                $_SESSION["Correo"]=$email;
                $sql="INSERT INTO recuperacion(Correo,Codigo) VALUES ('$email','$codigo')";
                if(mysqli_query($mysqli,$sql)){        
                    echo("Correcto");
                    echo("<script> 
                        alert('Comprueba tu correo electronico');
                        document.location.href = 'CodigoRecuperacion.php';
                    </script>");
                } else {
                    echo ''.mysqli_error($mysqli).'';
                }
                // echo("<script> 
                //         alert('Comprueba tu correo electronico');
                //         document.location.href = 'CodigoRecuperacion.php';
                //     </script>");
                // document.location.href = 'Login.php';
                mysqli_close($mysqli); 
            }
        }

            // echo("<script> 
            // alert('Comprueba tu correo electronico');
            // document.location.href = 'Login.php';
            // </script>");
    }

}
?>
    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>