<?php 
include 'database.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes - Explora el Mundo</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <header class="hero">
            <nav class="navbar">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="destinos.html">Destinos</a></li>
                   
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </nav>
            <h1>Descubre el mundo con nosotros</h1>
            <p>Viaja a destinos increíbles con ofertas exclusivas</p>
            <a href="#destinos" class="btn">Explorar Destinos</a>
        </header>

        <section id="destinos">
            <h2>Destinos Destacados</h2>
            <div class="gallery">
                <div class="card">
                    <img src="https://img.static-af.com/transform/45cb9a13-b167-4842-8ea8-05d0cc7a4d04/"alt="París">
                    <p>París, Francia</p>
                </div>
                <div class="card">
                    <img src=https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0j61BT-tzeke_UwzD9FpLOxlS2-7f_pBt3A&s" alt="Tokio">
                    <p>Tokio, Japón</p>
                </div>
                <div class="card">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/47/New_york_times_square-terabass.jpg" alt="Nueva York">
                    <p>Nueva York, EE.UU.</p>
                </div>
            </div>
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
</body>
</html>
</html>
