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
    <h4>Introduce el codigo de recuperacion</h4><br>

    <form name="codRecu" action="CodigoRecuperacion.php" method="POST">
    <div">
        Codigo
        <div>
            <input id="codigo" name="codigo" type="number" maxlength="6" max="999999" data-length="6" required />
        </div><br>
        <div>
            <button type="submit" class= "boton-3d" name="submit">Aceptar</button>
        </div>

    
    </form>

    <?php
    if(isset($_POST['submit'])){
        if (isset($_SESSION['Recuperando'])) {
            if ($_SESSION['Recuperando'] == 'SI') {
                $correo = $_SESSION['Correo'];
                //Ahora vamos a abrir una sesion con mysqli:
                $mysqli = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
                if(!$mysqli){
                    die("Hay algo raro que esta fallando con MySQL". mysql_connect_error());
                }
                $result = mysqli_query($mysqli,"select Codigo from recuperacion where Correo ='$correo' LIMIT 1");
                $cont = mysqli_num_rows($result); 
                if($cont == 0) {
                    echo ("Ha ocurrido un error");
                } else {
                    $usuario = $result->fetch_assoc();
                    $cod=$usuario["Codigo"];
                    if($cod != $_POST['codigo']){
                        echo "El codigo no es correcto";
                    } else {
                        echo "El codigo es correcto...";
                        echo("<script> 
                            document.location.href = 'NuevaContraseña.php';
                        </script>");
                    }
                }
                mysqli_close($mysqli); 
            }
        }
    }

?>
    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>