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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <section class="main" id="s1">
    <h2>Cambiar contraseña</h2><br>
    <h4>Introduce tu nueva contraseña</h4><br>

    <form name="cambioContra" action="NuevaContraseña.php" method="POST">
    <div">
        Password:* <input type="password" id="pass" name="pass" minlength="6" required><br><br>
        Repetir password:* <input type="password" id="passR" name="passR" minlength="6" required><br><br>
        <div id="SOAPPASS"></div><br>
        <button type="submit" class= "boton-3d" id="botonEnviar" name="submit">Aceptar</button><br>
    </form>

    <?php
    if(isset($_POST['submit'])){
        if (isset($_SESSION['Recuperando'])) {
            if ($_SESSION['Recuperando'] == 'SI') {
                $pass = $_POST['pass'];
                if($pass != $_POST['passR']){
                    echo "Las contraseñas no coinciden";
                } else {
                    $correo = $_SESSION['Correo'];
                    //Ahora vamos a abrir una sesion con mysqli:
                    $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
                    if(!$mysqli){
                        die("Hay algo raro que esta fallando con MySQL". mysql_connect_error());
                    }
                    $salt = '(|0.#f6cQn&';
                    $encriptPpass = md5($salt . md5($pass . $salt));
                    $result = mysqli_query($mysqli,"update usuarios set pass='$encriptPpass' where email ='$correo'");
                    if($result){        
                        echo("Correcto");
                        mysqli_query($mysqli,"delete from recuperacion where Correo ='$correo'");
                        echo("<script> 
                            alert('Contraseña modificada con exito');
                            document.location.href = 'Login.php';
                            
                        </script>");
                    } else {
                        echo ''.mysqli_error($mysqli).'';
                    }
                    mysqli_close($mysqli); 
                }
                
            }
        }
        

    }

?>
    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>
<script>

$(document).ready(function () {
    $('#botonEnviar').prop("disabled",true);
    XMLHttpRequestPass = new XMLHttpRequest();
    XMLHttpRequestPass.onreadystatechange = function () {
        if (XMLHttpRequestPass.readyState == 4) {
            var obj = document.getElementById('SOAPPASS');
            obj.innerHTML = XMLHttpRequestPass.responseText;
            if(XMLHttpRequestPass.responseText.includes("INVALIDA")){
                $('#botonEnviar').prop("disabled",true);
            }else{
                $('#botonEnviar').prop("disabled",false);    
            }
        }
    }
    $("#pass").focusout(function () {
        var data = new FormData();
        pass=$('#pass').val();
        data.append('pass', pass);
        XMLHttpRequestPass.open("POST", 'VerifyPassWS.php', true);
        XMLHttpRequestPass.send(data);
    });

});

</script>