<div id='page-wrap'>
    <header class='main' id='h1'>

        <?php
        if (isset($_SESSION['Autenticado'])) {
            if ($_SESSION['Autenticado'] == 'SI') {
                $correo = $_SESSION['Correo'];
                $imagen = $_SESSION['Imagen'];

                if($imagen == ''){
                    echo '<img src="../images/incognito.png" width="80">';
                } else {
                    if(base64_encode(base64_decode($imagen, true)) === $imagen){
                        echo '<img width=\'70\' height=\'70\' src=\'data:image/*;base64, '.$imagen.'\' alt=\'Usuario\'/>';
                    } else {
                        $size = getimagesize($imagen);
                        echo '<td><img src="'.$imagen.'" alt="Google" width="80"/></td>';
                    }

                 
                }

                echo '
                    ' . $correo . '
                    <span class="right"><a href="LogOut.php">Logout</a></span>
                    ';
            }
        } else {
            echo '
                <span class="right"><a href="SignUp.php">Registro</a></span>
                <span class="right"><a href="Login.php">Login</a></span>
                ';
        }
        ?>


    </header>
    <nav class='main' id='n1' role='navigation'>

        <?php
        if (isset($_SESSION['Autenticado']) && $_SESSION['Autenticado'] == 'SI') {
            if($_SESSION["Tipo"]=='3'){
                echo "
                <span><a href='Layout.php'>Inicio</a></span>
                <span><a href='Credits.php'>Creditos</a></span>
                <span><a href='HandlingAccounts.php'>Administración de usuarios.</a></span>
                ";
            }else
            echo "
  <span><a href='Layout.php'>Inicio</a></span>
  <span><a href='Credits.php'>Creditos</a></span>
  <span><a href='HandlingQuizesAjax.php'> Seccion de AJAX</a></span>
  ";
        } else {
            echo "
  <span><a href='Layout.php'>Inicio</a></span>
  <span><a href='Credits.php'>Creditos</a></span>
  ";
        }
        ?>
    </nav>