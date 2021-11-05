<?php
session_start();

if(!isset($_SESSION['Autenticado']) || $_SESSION['Autenticado']!='SI'){
    header("Location: Layout.php");
    exit();
}
if ($_SESSION['Tipo'] == '3') {
    header("Location: Layout.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <?php
  
include '../html/Head.html';
  
  ?>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="651662324010-g5bkf5ol8pc7culhr2r666bkseiiqgcn.apps.googleusercontent.com.apps.googleusercontent.com">
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1">
    <h2>¡Iniciar sesión!</h2><br>

    <?php
        $email=$_POST['mail'];
        $nomApe=$_POST['nombre'];
        $pass='GOOGLE';
        $tipo='1';
        $imagen = $_POST['image'];
        
        //Ahora vamos a abrir una sesion con mysqli:
        $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
        if(!$mysqli){
          die("Hay algo raro que esta fallando con MySQL". mysql_connect_error());
        }

        $usuarios = mysqli_query($mysqli,"select * from usuarios where email ='$email'");
        $cont = mysqli_num_rows($usuarios); 

        if($cont == 0){
            $sql="INSERT INTO usuarios(email,nomApe,pass,tipo, imagen, Bloqueado) VALUES ('$email','$nomApe','$pass', '$tipo', '$imagen','0')";
            //Ahora insertamos a la base de datos los datos de la pregunta
            if(mysqli_query($mysqli,$sql)){        
                echo("<script> 
                    alert('Usuario correctamente registrado');
                    document.location.href = 'Login.php';
                    </script>");
            } else {
                echo ''.mysqli_error($mysqli).'';
            }
        } 

        //mandale al inicio con su login hecho
        $_SESSION["Autenticado"]="SI";
        $_SESSION["Correo"]=$email;
        $_SESSION["Tipo"]=$tipo;
        $_SESSION['Imagen']=$imagen;
        echo '<script type="text/javascript">
            XMLHttpRequestObjectLogIn = new XMLHttpRequest();
            XMLHttpRequestObjectLogIn.open("POST", "IncreaseGlobalCounter.php", true);
            XMLHttpRequestObjectLogIn.send(null);
        </script>';
        echo ('<a>
        Bienvenido de vuelta! El inicio de sesión ha sido existoso.<br>
        <a href="Layout.php?mail='.$email.'">Continuar<a/>
        </a>');
        
    //Ahora cerramos la conexion con la base de datos
    mysqli_close($mysqli); 
    
   
    ?>
    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>