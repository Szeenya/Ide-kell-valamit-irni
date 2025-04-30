<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öltönykölcsönző - Főoldal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/style/main_style.css">
    <link rel="stylesheet" href="src/style/home_style.css">
    <link rel="stylesheet" href="src/style/navbar.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <main>
        <section class="hero">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/src/images/1slide.jpg" class="d-block-w-100" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img src="/src/images/2slide.jpg" class="d-block-w-100" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img src="/src/images/3slide.jpeg" class="d-block-w-100" alt="Third slide">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Széles Választék</h3>
                <p>Több száz öltöny közül választhat</p>
            </div>
            <div class="feature-card">
                <h3>Gyors Kiszolgálás</h3>
                <p>24 órán belüli átvétel</p>
            </div>
            <div class="feature-card">
                <h3>Rugalmas Feltételek</h3>
                <p>Kedvező bérleti feltételek</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="contact-info">
            <p>Kapcsolat: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>