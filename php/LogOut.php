<?php
session_start();
session_destroy();
?>
<script>
    
XMLHttpRequestObjectLogIn = new XMLHttpRequest();
XMLHttpRequestObjectLogIn.open("POST", "DecreaseGlobalCounter.php", true);
XMLHttpRequestObjectLogIn.send(null);



</script>'
<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
</head>
<body>
    <?php include '../php/MenusInicio.php' ?>
    <section class="main" id="s1">
    <h2>¡Has cerrado sesión correctamente!</h2><br>
    <a href="Layout.php">Continuar</a>

    </section>
    <?php include '../html/Footer.html' ?>

</body>
</html>