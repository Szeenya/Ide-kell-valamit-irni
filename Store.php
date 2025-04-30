<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/config.php';
require_once 'models/SuitModel.php';

$suitModel = new SuitModel();
$suits = $suitModel->getAllSuits();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="src/style/main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/navbar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/hu.js"></script>
<<<<<<< Updated upstream
=======
    <link rel="stylesheet" href="store_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
>>>>>>> Stashed changes
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <main>
<<<<<<< Updated upstream
        <section class="products">
            <div class="product-list">
                <?php foreach ($suits as $suit): ?>
                <div class="product-card" 
                     data-suit-id="<?php echo $suit['id']; ?>"
                     onclick="showModal(
                        <?php echo $suit['id']; ?>,
                        'src/images/kep1.jpg', 
                        'Méret: <?php echo "Nyak: {$suit['neck']}cm, Ujj: {$suit['sleve']}cm, Derék: {$suit['waist']}cm, Mellkas: {$suit['chest']}cm"; ?>', 
                        '<?php echo number_format($suit['price'], 0, ',', ' ') . ' Ft'; ?>', 
                        '<?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?>')">
                    <img src="src/images/kep1.jpg" 
                         alt="<?php echo htmlspecialchars($suit['type']); ?>" 
                         class="product-image">
                    <h3 class="product-title"><?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?></h3>
                    <p class="product-price"><?php echo number_format($suit['price'], 0, ',', ' '); ?> Ft</p>
=======
        <div class="container-fluid">
            <div class="row">
                <!-- Termékek listája -->
                <div class="col-md-9">
                    <section class="products">
                        <div class="product-list">
                            <?php foreach ($suits as $suit): ?>
                            <div class="product-card" 
                                 data-suit-id="<?php echo $suit['id']; ?>"
                                 onclick="showModal(
                                    <?php echo $suit['id']; ?>,
                                    'src/images/oltony<?php echo $suit['id']; ?>.jfif', 
                                    'Méret: <?php echo "Nyak: {$suit['neck']}cm, Ujj: {$suit['sleve']}cm, Derék: {$suit['waist']}cm, Mellkas: {$suit['chest']}cm"; ?>', 
                                    '<?php echo number_format($suit['price'], 0, ',', ' ') . ' Ft'; ?>', 
                                    '<?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?>')">
                                <img src="src/images/oltony<?php echo $suit['id']; ?>.jfif" 
                                     alt="<?php echo htmlspecialchars($suit['type']); ?>" 
                                     class="product-image">
                                <h3 class="product-title"><?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?></h3>
                                <p class="product-price"><?php echo number_format($suit['price'], 0, ',', ' '); ?> Ft</p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
>>>>>>> Stashed changes
                </div>

        <!-- Modal ablak -->
        <div id="product-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="hideModal()">&times;</span>
                <img id="modal-image" src="" alt="Termék kép">
                <h3 id="modal-title"></h3>
                <p id="modal-description"></p>
<<<<<<< Updated upstream
                <p id="modal-price"></p>
                <div class="date-selection">
                    <label for="rental-dates">Bérlés időtartama:</label>
                    <input type="text" id="rental-dates" class="date-range" placeholder="Válassza ki a dátumokat">
                </div>
                <button class="modal-button" onclick="addToCart(currentSuitId)">Kosárba</button>
            </div>
        </div>

        <!-- Egyetlen kosár -->
        <div class="cart-wrapper">
            <div id="cart" class="cart-main">
                <h3>Kosár</h3>
                <div class="cart-content">
                    <ul id="cart-items"></ul>
                    <div id="cart-total">Összesen: 0 Ft</div>
                    <button onclick="clearCart()">Kosár törlése</button>
=======
                <p id="modal-base-price"></p>
                <p id="modal-total-price"></p>
                <div class="date-selection">
                    <label for="rental-dates">Bérlés időtartama:</label>
                    <input type="text" id="rental-dates" class="date-range" placeholder="Válassza ki a dátumokat">
>>>>>>> Stashed changes
                </div>
                <button class="modal-button" onclick="ShowModal(currentSuitId)">Foglalás</button>
            </div>
        </div>
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