<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <?php
  
include '../html/Head.html';
  
  ?>
  <style>
 .g-signin2 {
  display: flex;
  justify-content: center;
}
</style>
 
  <script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="651662324010-g5bkf5ol8pc7culhr2r666bkseiiqgcn.apps.googleusercontent.com">
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <section class="main" id="s1">
    <h2>¡Iniciar sesión!</h2><br>
    <div>
        <form name="login" action="Login.php" method="POST">

            Email:* <input type="text" id="email" name="email" required><br><br>
            Password:* <input type="password" id="pass" name="pass" required><br><br>

            <button type="submit" class= "boton-3d">Iniciar sesion</button><br><br>
            <a href="RecuperacionContraseña.php">¿Has olvidado tu contraseña?</a>
        </form>
        <form id="googleForm" name="googleForm" method="post" action="<GoogleLogin.php">
            <input type="hidden" name="nombre" id="nombre" value="">
            <input type="hidden" name="image" id="image" value="">
            <input type="hidden" name="mail" id="mail" value="">
        </form>
        <br>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
       
    </div>

    <?php
    if(isset($_POST['email'])&& strlen($_POST['email'])!=0){
        $email=$_POST['email'];
        $pass=$_POST['pass'];
         //$mysqli = mysqli_connect("localhost", "id14878982_root", "ContraRoot_99", "id14878982_quiz");        

        // $mysqli = mysqli_connect ("localhost", "root", "pass", "preguntas");

        //Ahora vamos a abrir una sesion con mysqli:
        $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
        //$mysqli = mysqli_connect ("localhost", "id14912528_rootbd", "x@2E0W^Qtpa]|ok-", "id14912528_quizbd");
        if(!$mysqli){
          die("Hay algo raro que esta fallando con MySQL". mysql_connect_error());
        }

        $result = mysqli_query($mysqli,"select * from usuarios where email ='$email' LIMIT 1");
        
        $cont = mysqli_num_rows($result); 

        if($cont == 1){
            //El usuario existe, comprobar contraseña
            $usuario = $result->fetch_assoc();
            $mail=$usuario["email"];
            $salt = '(|0.#f6cQn&';
            $encriptPass = md5($salt . md5($pass . $salt));
            $imagen = $usuario["imagen"];
            if(strcmp($encriptPass,$usuario['pass'])){
                echo ("
                La contraseña no es correcta");
            }else if($usuario['Bloqueado']==1){
                echo ("
                El usuario esta bloqueado");
            }else{
                $correoaqui=$mail;
                
                $_SESSION["Autenticado"]="SI";
                $_SESSION["Correo"]=$mail;
                $_SESSION["Tipo"]=$usuario["tipo"];
                $_SESSION['Imagen']=$imagen;
                echo ('<a>
                Bienvenido de vuelta! El inicio de sesión ha sido existoso.<br>
                <a href="Layout.php?mail='.$mail.'">Continuar<a/>
                </a>');
            echo '<script type="text/javascript">
                    XMLHttpRequestObjectLogIn = new XMLHttpRequest();
                    XMLHttpRequestObjectLogIn.open("POST", "IncreaseGlobalCounter.php", true);
                    XMLHttpRequestObjectLogIn.send(null);
                </script>';
            }
            

        } else {
            //El usuario no existe
            echo "
                <a>
                    El usuario no esta registrado.
                </a>" ;  
        }

    //Ahora cerramos la conexion con la base de datos
    mysqli_close($mysqli); 
    }
   
    ?>
    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  document.googleForm.nombre.value = profile.getName();
  document.googleForm.image.value = profile.getImageUrl();
  document.googleForm.mail.value = profile.getEmail();
  if(profile.getEmail() != "help.quizeljuego@gmail.com"){
    GoogleAuth.signOut();
    document.forms["googleForm"].submit();
  }

}


  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

</script>