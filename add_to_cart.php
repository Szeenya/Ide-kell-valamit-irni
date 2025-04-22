<?php
session_start();
require_once 'config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nincs bejelentkezve!']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['suit_id']) || !isset($data['start_date']) || !isset($data['end_date'])) {
    echo json_encode(['success' => false, 'message' => 'Hiányzó adatok!']);
    exit;
}

try {
    // Ellenőrizzük, hogy az öltöny elérhető-e a választott időszakban
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM shopping_cart 
        WHERE suit_id = ? AND 
        ((rented_from BETWEEN ? AND ?) OR 
         (rented_until BETWEEN ? AND ?) OR
         (rented_from <= ? AND rented_until >= ?))
    ");
    
    $stmt->execute([
        $data['suit_id'],
        $data['start_date'],
        $data['end_date'],
        $data['start_date'],
        $data['end_date'],
        $data['start_date'],
        $data['end_date']
    ]);

    if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Az öltöny már foglalt ebben az időszakban!']);
        exit;
    }

    // Ha elérhető, hozzáadjuk a kosárhoz
    $stmt = $pdo->prepare("
        INSERT INTO shopping_cart (user_id, suit_id, rented_from, rented_until) 
        VALUES (?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $data['suit_id'],
        $data['start_date'],
        $data['end_date']
    ]);

    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Adatbázis hiba történt!']);
}

?>

<div class="product-card" onclick="showModal(
    <?php echo $suit['id']; ?>,
    'src/images/kep1.jpg', 
    'Méret: <?php echo "Nyak: {$suit['neck']}cm, Ujj: {$suit['sleve']}cm, Derék: {$suit['waist']}cm, Mellkas: {$suit['chest']}cm"; ?>', 
    '<?php echo number_format($suit['price'], 0, ',', ' ') . ' Ft'; ?>', 
    '<?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?>')">