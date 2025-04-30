<!-- filepath: c:\Users\gyuri\Desktop\suitv5\aboutus.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rólunk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style/main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/navbar.css">
    <link rel="stylesheet" href="src/style/aboutus_style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <main>
        <section class="about-us">
            <h2>Rólunk</h2>
            <p>Üdvözöljük az Öltönykölcsönző weboldalán! Cégünk több mint 10 éve foglalkozik prémium minőségű öltönyök bérbeadásával. Küldetésünk, hogy minden ügyfelünk számára elérhetővé tegyük a tökéletes megjelenést, legyen szó esküvőről, üzleti találkozóról vagy bármilyen különleges alkalomról.</p>
            
            <h3>Miért válasszon minket?</h3>
            <ul>
                <li>Széles választék: Több száz öltöny különböző stílusban és méretben.</li>
                <li>Rugalmas bérlési feltételek: Rövid és hosszú távú bérlés is elérhető.</li>
                <li>Kiváló ügyfélszolgálat: Szakértő csapatunk mindig készen áll segíteni.</li>
            </ul>

            <h3>Kapcsolat</h3>
            <p>Ha bármilyen kérdése van, forduljon hozzánk bizalommal:</p>
            <p>Email: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
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