<?php
session_start();

if (!isset($_SESSION['Autenticado']) || $_SESSION['Autenticado'] != 'SI') {
    header("Location: Layout.php");
    exit();
}
if ($_SESSION['Tipo'] != '3') {
    header("Location: Layout.php");
    exit();
}
include '../php/Menus.php';
?>


<!DOCTYPE html>
<html>

<head>
    <?php include '../html/Head.html' ?>
    <style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: left;
    }
    th {
        background-color: grey;
        color: white;
    }
    td {
        background-color: white;
        color: black;
    }
  </style>
</head>

<body>
    <section class="main" id="s1">
        <h1>Gestion de usuarios.</h1>
        <div>
            <?php
        $link = mysqli_connect("localhost", "id14912528_root", "ContraRoot_99", "id14912528_quiz");
        $preguntas = mysqli_query($link, "select * from usuarios");
            echo  '<table style="margin-left: auto; margin-right: auto;" border=1 > <tr> <th> Imagen </th> <th> Nombre </th> <th> Correo </th> <th> Contraseña </th> <th> Tipo de usuario </th> <th> Estado </th> <th> Bloquear </th> <th> Eliminar </th> </tr>';
            while ($row = mysqli_fetch_array($preguntas)) {
                $imagen = $row['imagen'];
                if ($row['tipo'] == '1') {
                    $tipo = "Alumno";
                } else if ($row['tipo'] == '2') {
                    $tipo = "Profesor";
                } else if ($row['tipo'] == '3') {
                    $tipo = "Administrador";
                }
                if ($row['Bloqueado'] == 0) {
                    $estado = "Activo";
                    $boton="Bloquear";
                } else {
                    $estado = "Bloqueado";
                    $boton="Desbloquear";
                }
                if ($row['tipo'] == '3') {
                    //No bloquear ni eliminar
                    echo '<tr>';
                    if($imagen == ''){
                        echo '<td><img src="../images/incognito.png" width="80"></td>';
                    } else {
                        echo '<td><img width=\'80\' height=\'80\' src=\'data:image/*;base64, '.$imagen.'\' alt=\'Usuario\'/></td>';
                    }

                    echo '<td>' . $row['nomApe'] . '</td> <td>' . $row['email'] . '</td> <td>' . $row['pass'] . '</td> <td>' . $tipo . '</td> <td>' . $estado . '</td>
                    <td> NO  </td>
                    <td> NO </td>
                    </tr>';
                } else {
                    echo '<tr>';
                    if($imagen == ''){
                        echo '<td><img src="../images/incognito.png" width="80"></td>';
                    } 
                    else if ($row['pass'] == 'GOOGLE') {
                        echo '<td><img src="'.$imagen.'" alt="Google" width="80"/></td>';
                    } 
                    else {
                        echo $imagen;
                        echo '<td><img width=\'80\' height=\'80\' src=\'data:image/*;base64, '.$imagen.'\' alt=\'Usuario\'/></td>';
                    }
                    echo '<td>' . $row['nomApe'] . '</td> <td>' . $row['email'] . '</td> <td>' . $row['pass'] . '</td> <td>' . $tipo . '</td> <td>' . $estado . '</td> 
                    <td> <button class="boton-3d" id="'.$row['email'].'" > '.$boton.' </button>  </td> 
                    <td> <button class="boton-3d" id="Eli'.$row['email'].'"> Eliminar usuario </button></td> 
                    </tr>
                    <script type="text/javascript">
                        document.getElementById("'.$row['email'].'").onclick = function () {
                            var opcion = confirm("¿Cambiar estado?");
                            if (opcion == true) {
                                location.href = "ChangeUserState.php?usu='.$row['email'].'&modo='.$row['Bloqueado'].'";
                                alert("Estado cambiado");
                            } 
                        };

                        document.getElementById("Eli'.$row['email'].'").onclick = function () {
                            var opcion = confirm("¿Eliminar usuario?");
                            if (opcion == true) {
                                location.href = "RemoveUser.php?usu='.$row['email'].'";
                                alert("Usuario correctamente eliminado");
                            } 
                        };
                     
                    </script>

                    ';

                    
                }
            }
            echo '</table>';
            $preguntas->close();
            mysqli_close($link);
            ?>
        </div>
    </section>
    <?php include '../html/Footer.html' ?>
</body>

</html>