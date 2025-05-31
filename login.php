<?php
session_start();
include 'database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];


    //validacion de errores de parte del servidor
    if (empty($username)) {
        $errors[] = "Debe colocar el usuario";
    }
    if (strlen($username) < 3) {
    $errors[] = "El username debe tener más de 3 letras";
    }

    if (strlen($password) < 5) {
    $errors[] = "La contraseña debe tener más de 5 letras";
    }

    if (empty($password)) {
        $errors[] = "Debe colocar la contraseña";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //verifica que la tabla de usuarios tiene la contraseña
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['id_usuario'] = $usuario['id'];
            header("Location: index.php");
            exit;
        } else {
            $errors[] = "Credenciales no válidas ";
        }
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
                    <li> <a href="register.php">Registro Usuario</a></li>
                    <li> <a href="login.php">Identificarse</a></li>
                    <li><a href="createguide.php">Creacion de Guía</a></li>
                     <li><a href="destinos.php">Listado de Destinos</a></li>
                </ul>
            </nav>
            <h1>Identificate</h1>
            <p>Encuentra el lugar perfecto para tu próxima aventura</p>
        </header>

         <section class="contact-form">
            <h2>Formulario de ini ciosesión</h2>
            <!--con este codigo mostramos la lista de errores del lado del servidor-->
            <?php if (!empty($errors)): ?>
                 <div class="error-list">
                     <ul>
                         <?php foreach ($errors as $error): ?>
                             <li><?= htmlspecialchars($error) ?></li>
                         <?php endforeach; ?>
                     </ul>
                 </div>
            <?php endif; ?>

            <!-- formulario para iniciar sesión-->
            <form action="#" method="post" id="formulario">

                    <label for="username">Nombre de usuario:</label><!--Hacemos que el usuario ponga su usuario y su contraseña para después verificarlos-->
                    <input type="text" id="username" name ="username">
                    <div class="error" id="error-username"></div>

                    <label for ="password">Contraseña</label>
                    <input type="password" id="password" name ="password">
                    <div class="error" id="error-password"></div>

                    <button type="button" class="btn" id="enviar">Identificarse</button>  <!--hacemos un boton type Button para controlar cuando enviar el formulario -->
                    <p class="mt-3">¿No tienes cuenta? <a href="register.php">¡Registrate aquí!</a></p>

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
    </div>
    <script>

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
            }else if(password.value.trim().length < 5){
                esvalido = false;
                error_password.textContent ="La contraseña debe tener más de 5 letras";
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