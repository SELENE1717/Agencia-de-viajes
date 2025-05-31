<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pais = trim($_POST['pais']);
  $ciudad = trim($_POST['ciudad']);
  $pasaporte = $_POST['pasaporte']; // "1" o "0"
  $creado_por = $_SESSION['usuario_id'] ?? null;

  $errores = [];

  if (empty($pais)) {
    $errores[] = "El país es obligatorio.";
  } elseif (strlen($pais) < 3) {
    $errores[] = "El país debe tener al menos 3 caracteres.";
  }

  if (empty($ciudad)) {
    $errores[] = "La ciudad es obligatoria.";
  }

  if (!isset($pasaporte) || ($pasaporte !== "1" && $pasaporte !== "0")) {
    $errores[] = "Debe seleccionar si requiere pasaporte.";
  }

  if (empty($creado_por)) {
    $errores[] = "No se ha podido identificar al usuario que crea el destino.";
  }

  if (empty($errores)) {
    $stmt = $pdo->prepare("INSERT INTO destino (pais, ciudad, pasaporte, creado_por) VALUES (?, ?, ?, ?)");
    $stmt->execute([$pais, $ciudad, $pasaporte, $creado_por]);
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
    <title>Contacto - Agencia de Viajes</title>
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
                    <li> <a href="login.php">Identificación</a><li>
                    <li><a href="createguide.php">Creacion de Guía</a></li>
                </ul>
            </nav>
            <h1>Contáctanos</h1>
            <p>Estamos aquí para ayudarte a planear tu próxima aventura</p>
        </header>

        <section class="contact-form">
            <h2>Crea un destino</h2>
            <form action="#" method="post" id="formulario">
                <fieldset>
                    <legend>Detalles del Destino</legend>
                    <label for="pais">País:</label>
                    <input type="text" id="pais" >
                    <div class="error" id="error-pais"></div>

                    <label for="ciudad">Ciudad:</label>
                    <input type="text" id="ciudad">
                    <div class="error" id="error-ciudad"></div>

                    <label for="pasaporte">Requiere pasaporte:</label>
                     <select  id="pasaporte" name="pasaporte">
                     <option value="1">si</option>
                     <option value="0">no</option>
                     <select>
                    <div class="error" id="error-pasaporte"></div>
                </fieldset>

                <button type="button" class="btn" id="enviar">Enviar Destino</button> <!--hacemos un boton type Button para controlar cuando enviar el formulario -->
            </form>
        </section>

        <section class="map">
            <h2>Nuestra Ubicación</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>

        <footer>
            <p>© 2025 Agencia de Viajes. Todos los derechos reservados.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </footer>
    </div>
    <script>

        let pais = document.getElementById("pais");
        let ciudad = document.getElementById("ciudad");
        let pasaporte = document.getElementById("pasaporte");


        //recogemos los divs de los errores para llamarlos en la funcion
        let error_ciudad = document.getElementById("error-ciudad");
        let error_pais = document.getElementById("error-pais");
        let error_pasaporte = document.getElementById("error-pasaporte");

        function validar(){ //funcion que valida el formulario

            let esvalido = true;
            if (pais.value.trim() ===''){
                esvalido= false;
                error_pais.textContent = "El pais es obligatorio";
            }else if(pais.value.trim().length() < 3){
                esvalido = false;
                error_pais.textContent =" El pais debe tener más de 3 letras";
            }else if(ciudad.value.trim() ===''){
                esvalido = false;
                error_ciudad.textContent = "El ciudad es obligatorio";
            }else if (pasaporte.value !== "1" && pasaporte.value !== "0") {
                esvalido = false;
                error_pasaporte.textContent = "Debe seleccionar si requiere pasaporte.";
}
    
            return esvalido;
        }

         let enviar = document.getElementById('enviar');
         let formulario = document.getElementById('formulario');

         enviar.addEventListener('click', e=>{
              e.preventDefault();
            if (validar()){
                formulario.submit();

            }
         });

    </script>
</body>
</html>
