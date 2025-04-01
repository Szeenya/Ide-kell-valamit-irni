<?php
session_start();
require_once 'config/config.php';
require_once 'controllers/SuitController.php';

// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$suitController = new SuitController();
$suits = $suitController->getSuits();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öltönykölcsönző</title>
    <link rel="stylesheet" href="src/style/main_style.css">
</head>
<body>
    <header>
        <h1>Öltönykölcsönző</h1>
        <nav>
            <ul>
                <li><a href="#Home">Kezdőlap</a></li>
                <li><a href="#Suits">Termékek</a></li>
                <li><a href="#About">Rólunk</a></li>
                <li><a href="#Contact">Kapcsolat</a></li>
                <li>
                    <form action="index.php" method="POST" style="display: inline;">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">Kijelentkezés</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="products">
            <div class="product-list">
                <?php foreach ($suits as $suit): ?>
                    <div class="product-card" onclick="showModal(
                            '<?php echo htmlspecialchars($suit['img_dir'] ?? 'src/images/kep1.jpg'); ?>', 
                            '<?php echo htmlspecialchars($suit['type']); ?>', 
                            '<?php echo htmlspecialchars($suit['color']); ?>', 
                            <?php echo $suit['neck']; ?>, 
                            <?php echo $suit['sleve']; ?>, 
                            <?php echo $suit['waist']; ?>, 
                            <?php echo $suit['chest']; ?>,
                            <?php echo $suit['price']; ?>
                        )">
                        <img src="<?php echo htmlspecialchars($suit['img_dir'] ?? 'src/images/kep1.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($suit['type']); ?>" 
                             class="product-image">
                        <h3 class="product-title"><?php echo htmlspecialchars($suit['type']); ?></h3>
                        <p class="product-price"><?php echo number_format($suit['price'], 0, '.', ' '); ?> Ft</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="cart-wrapper">
            <div class="cart-main">
                <h3>Kosár</h3>
                <div class="cart-content">
                    <div id="cart-items"></div>
                    <div id="cart-total">Összesen: 0 Ft</div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="product-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="hideModal()">&times;</span>
                <img id="modal-image" src="" alt="Termék kép">
                <h3 id="modal-title"></h3>
                <div id="modal-description"></div>
                <p id="modal-price"></p>
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