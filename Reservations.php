<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/config.php';
require_once 'models/SuitModel.php';

// MySQLi kapcsolat létrehozása
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Kapcsolat ellenőrzése
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$suitModel = new SuitModel();
$suits = $suitModel->getAllSuits();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalásaim</title>
    <link rel="stylesheet" href="src/style/main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="src/style/reservations.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/hu.js"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="reservations-container">
        <?php
        $user_id = $_SESSION['user_id'];
        
        $sql = "SELECT r.*, s.type as name, s.price 
                FROM reservations r 
                JOIN suits s ON r.suit_id = s.id 
                WHERE r.user_id = ? 
                AND (r.is_canceled IS NULL OR r.is_canceled = 0)
                ORDER BY r.added_at DESC";
                
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<div class="reservations-grid">';
                while ($r = $result->fetch_assoc()) {
                    // Számítsuk ki a napok számát
                    $start_date = new DateTime($r['rented_from']);
                    $end_date = new DateTime($r['rented_until']);
                    $days_diff = $start_date->diff($end_date)->days + 1;
                    
                    // Számítsuk ki a teljes árat
                    $base_price = $r['price'];
                    $total_price = $base_price + (($days_diff - 1) * ($base_price * 0.5));
                    
                    echo '<div class="reservation-card">
                            <h3>' . htmlspecialchars($r['name']) . '</h3>
                            <p>Mennyiség: ' . $r['quantity'] . ' db</p>
                            <p>Foglalás: ' . date('Y-m-d H:i', strtotime($r['added_at'])) . '</p>
                            <p>Bérlés kezdete: ' . date('Y-m-d', strtotime($r['rented_from'])) . '</p>
                            <p>Bérlés vége: ' . date('Y-m-d', strtotime($r['rented_until'])) . '</p>
                            <p>Alapár: ' . number_format($base_price, 0, ',', ' ') . ' Ft</p>
                            <p>Teljes ár (' . $days_diff . ' nap): ' . number_format($total_price, 0, ',', ' ') . ' Ft</p>
                            <button class="cancel-btn" onclick="cancelReservation(' . $r['id'] . ')">Foglalás törlése</button>
                          </div>';
                }
                echo '</div>';
            } else {
                echo '<p class="no-reservations">Még nincsenek foglalásaid.</p>';
            }
            $stmt->close();
        } else {
            echo '<p class="error">Hiba történt a foglalások betöltése közben.</p>';
        }
        
        $mysqli->close();
        ?>
    </main>

    
    <footer>
        <div class="contact-info">
            <p>Kapcsolat: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
        </div>
    </footer>

    <script src="src/scripts/main_script.js"></script>
</body>
</html>