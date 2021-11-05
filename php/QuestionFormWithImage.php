<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <script src="../js/ValidateFieldsQuestion.js"></script>
</head>
<body>
  <?php 
  if(isset($_GET['mail'])){
   $correoaqui=$_GET['mail'];
  include '../php/Menus.php';
 }else{
     echo 'No tienes permiso para estar aqui';
     include '../php/Menus.php';
     die();
 } ?>
  <section class="main" id="s1">
    <h2>¡Añade una nueva pregunta a nuestro formulario!</h2><br>
    <div>
    
      <form name="InsertarPregunta" action="AddQuestion.php" method="POST">
      <input type="hidden" id="mail" name="mail" value=<?php echo "".$correoaqui.""?>>
      Inserta el correo electronico: <input type="text" id="correo" name="correo" value=<?php echo "".$correoaqui.""?>><br><br>
      Cual es el enunciado de la pregunta? <input type="text" id="enunciado" name="enunciado"><br><br>
      Respuesta correcta: <input type="text" id="correcta" name="correcta"><br><br>
      Respuesta incorrecta 1: <input type="text" id="inc1" name="inc1"><br><br>
      Respuesta incorrecta 2: <input type="text" id="inc2" name="inc2"><br><br>
      Respuesta incorrecta 3: <input type="text" id="inc3" name="inc3"><br><br>
      Complejidad de la pregunta: 
      <div id="botones">
                <br>
                <input type="radio" id="facil" name="complej" value="1" checked="checked">
                <label for="facil">Fácil</label>
                <input type="radio" id="medio" name="complej" value="2">
                <label for="medio">Medio</label>
                <input type="radio" id="dificil" name="complej" value="3">
                <label for="dificil">Dificil</label> <br>
      </div>
      Inserte el tema: <input type="text" id="tema" name="tema"><br>
      
      <input type="file" id="img" name="imagen" accept=".jpeg, .jpg, .png"><br>
      <div id="botones">
      <button type="submit" onclick="return validar();" class="boton-3d">Guardar las preguntas</button>
      <input type="reset" value="¡Borrar!"class="boton-3d"><br>
      <output id="list"></output><br>
    </div>
      </form>
    </div>

  </section>
  <?php include '../html/Footer.html' ?>
</body>
<script>
  document.getElementById('img').addEventListener('change', mostrarImagen, false);
</script>
</html>
