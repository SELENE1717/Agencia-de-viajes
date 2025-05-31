<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    //datos usuario
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $nombre = trim($_POST['nombre']);
  $apellidos = trim($_POST['apellidos']);
  $edad = trim($_POST['edad']);
  $email = trim($_POST['email']);

  $tienePasaporte = isset($_POST['pasaporte']) ? $_POST['pasaporte'] : '0';
  //datos pasaporte 
   $numero = trim($_POST['numero']);
   $fechaExpedicion = trim($_POST['fechaexpedicion']);
   $caducidad = trim($_POST['caducidad']);


   //validación de datos por parte del servidor
  $errores = [];

  if (empty($username)) {
    $errores[] = "El usuario es obligatorio.";
  } elseif (strlen($username) < 3) {
    $errores[] = "El usuario debe tener al menos 3 caracteres.";
  }

  if (empty($password)) {
    $errores[] = "La password es obligatoria.";
  }

   if (empty($nombre)) {
  $errores[] = "El nombre es obligatorio.";
} elseif (strlen($nombre) < 3) {
  $errores[] = "El nombre debe tener al menos 3 caracteres.";
   } 

    if (empty($edad) || !is_numeric($edad) || $edad < 18) {
        $errores[] = "Debe ser mayor de edad.";
    }

    if (empty($email)) {
        $errores[] = "El email es obligatorio.";
    }

     if ($tienePasaporte !== "0" && $tienePasaporte !== "1") {
        $errores[] = "Debe indicar si tiene pasaporte.";
    }

    // Si tiene pasaporte, los campos deben estar completos
    if ($tienePasaporte === "1") {
        if (empty($numero)) {
            $errores[] = "Debe indicar el número de pasaporte.";
        }
        if (empty($fechaexpedicion)) {
            $errores[] = "Debe indicar la fecha de expedición del pasaporte.";
        }
        if (empty($caducidad)) {
            $errores[] = "Debe indicar la fecha de caducidad del pasaporte.";
        }
    }


  //si no hay errores en los datos del usuario se añaden a la tabla
  if (empty($errores)) {
    $stmt = $pdo->prepare("INSERT INTO usuario (username, password, nombre, apellidos, edad, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $password, $nombre, $apellidos, $edad, $email]);

    //como hemos colocado que nuestro ID se genere automáticamente por ser SERIAL, tenemos que recuperar este id
    $usuario_id = $pdo->lastInsertId();

    // si hemos seleccionado que si tenemos pasaporte se añadirán los datos a la tabla
    if ($tienePasaporte === "1") {
            $stmtPasaporte = $pdo->prepare("INSERT INTO pasaporte (usuario_id, numero, fecha_expedicion, caducidad) VALUES (?, ?, ?, ?)");
            $stmtPasaporte->execute([$usuario_id, $numero, $fechaExpedicion, $caducidad]);
            }
    header("Location: index.php");
    exit;
  } else {
    $_SESSION['errores'] = $errores;
    header("Location: create.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <header class="hero">
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="create.php">Creación de Destinos</a></li>
                    <li> <a href="register.php">Registro Usuario</a><li>
                    <li> <a href="login.php">Identificarse</a><li>
                    <li><a href="createguide.php">Creacion de Guía</a></li>
                     <li><a href="destinos.php">Listado de Destinos</a></li>
                </ul>
            </nav>
            <h1>Registrate</h1>
            <p>Encuentra el lugar perfecto para tu próxima aventura</p>
        </header>
         <section class="contact-form">
            <h2>Formulario de registro</h2>
            <form action="#" method="post" id="formulario">
                <fieldset>
                    <legend>Detalles del usuario</legend> 
                    <label for="username">Nombre de usuario:</label><!--necesitamos un nombre de usuario y una contraseña para luego identificarlo en el login-->
                    <input type="text" id="username" name ="username">
                    <div class="error" id="error-username"></div>

                    <label for ="password">Contraseña</label>
                    <input type="password" id="password" name ="password">
                    <div class="error" id="error-password"></div>

                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name ="nombre">
                    <div class="error" id="error-nombre"></div>

                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos">
                    <div class="error" id="error-apellidos"></div>

                    <label for="edad">Edad</label>
                    <input type="text" id="edad" name="edad">
                    <div class="error" id="error-edad"></div>

                    <label for="email">Email</label>
                    <input type="text" id="email" name ="email">
                    <div class="error" id="error-email"></div>

                    <label for="Tienepasaporte">¿Tiene pasaporte?</label> <!-- luego con los codigos en funcion de su selección deberá añadir los demás campos o no-->
                     <select  id="pasaporte" name="pasaporte">
                     <option value="1">si</option>
                     <option value="0">no</option>
                     </select>
                    <div class="error" id="error-pasaporte"></div>

                    <legend>Detalles del pasaporte (OPCIONAL)</legend>
                    <label for="numero">Numero pasaporte:</label>
                    <input type="text" id="numero" name="numero">
                    <div class="error" id="error-numpass"></div>

                    <label for="fechaexpedicion">Fecha de expedición:</label>
                    <input type="fecha" id="fechaexpedicion" name="fechaexpedicion">
                    <div class="error" id="error-fechaex"></div>

                    <label for="caducidad">Fecha de caducidad:</label>
                    <input type="fecha" id="caducidad" name="caducidad">
                    <div class="error" id="error-caducidad"></div>
                <button type="button" class="btn" id="enviar">Registrarse</button>  <!--hacemos un boton type Button para controlar cuando enviar el formulario -->
                </fieldset>
                     </form>
        </section>

           <footer>
            <p>© 2025 Agencia de Viajes. Todos los derechos reservados.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </footer>
                
<script>
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        let nombre = document.getElementById("nombre");
        let edad = document.getElementById("edad");
        let email = document.getElementById("email");

        //recogemos los divs de los errores para llamarlos en la funcion
        let error_password = document.getElementById("error-password");
        let error_username = document.getElementById("error-username");
        let error_nombre = document.getElementById("error-nombre");
        let error_edad = document.getElementById("error-edad");
        let error_email = document.getElementById("error-email");

        let pasaporte = document.getElementById("pasaporte");
        let numero = document.getElementById("numero");
        let fechaexpedicion = document.getElementById("fechaexpedicion");
        let caducidad = document.getElementById("caducidad");

        let error_pasaporte = document.getElementById("error-pasaporte");
        let error_numpass = document.getElementById("error-numpass");
        let error_fechaex = document.getElementById("error-fechaex");
        let error_caducidad = document.getElementById("error-caducidad");

        function validar(){ //funcion que valida el formulario

            let esvalido = true;
            if (username.value.trim() ===''){
                esvalido= false;
                error_username.textContent = "El username es obligatorio";
            }else if(username.value.trim().length < 3){
                esvalido = false;
                error_username.textContent =" El username debe tener más de 3 letras";
            }else if(password.value.trim() ===''){
                esvalido = false;
                error_password.textContent = "El password es obligatorio";
            }else if(username.value.trim().length < 5){
                esvalido = false;
                error_password.textContent ="La contraseña debe tener más de 5 letras";
            }else  if (nombre.value.trim() ===''){
                esvalido= false;
                error_nombre.textContent = "Debe completar el nombre";
            }else  if (edad.value.trim() ==='' || edad.value.trim() < 18){
                esvalido= false;
                error_edad.textContent = "Debe ser mayor de edad";
            }else if (email.value.trim() === ''){
                esvalido= false;
                error_edad.textContent = "Debe completar el email";
            }else if (pasaporte.value !== "1" && pasaporte.value !== "0") {
                esvalido = false;
                error_pasaporte.textContent = "Debe seleccionar si tiene pasaporte.";
            } if (pasaporte.value !== "1" && pasaporte.value !== "0") {
            esvalido = false;
            error_pasaporte.textContent = "Debe seleccionar si tiene pasaporte.";
        }

        // Si tiene pasaporte, tendrá que completar los campos obligatorios
        if (pasaporte.value === "1") {
            if (numero.value.trim() === '') {
                esvalido = false;
                error_numpass.textContent = "Debe indicar el número de pasaporte.";
            }
            if (fechaexpedicion.value.trim() === '') {
                esvalido = false;
                error_fechaex.textContent = "Debe indicar la fecha de expedición.";
            }
            if (caducidad.value.trim() === '') {
                esvalido = false;
                error_caducidad.textContent = "Debe indicar la fecha de caducidad.";
            }
        }
    
            return esvalido;
        }



         let enviar = document.getElementById('enviar');
         let formulario = document.getElementById('formulario');

         enviar.addEventListener('click', e=>{
              e.preventDefault();
            if (validar()){ //si el formulario es válido (true) lo manda
                formulario.submit();

            }
         });
</script>
</body>
</html>

                
