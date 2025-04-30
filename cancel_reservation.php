<?php
session_start();
require_once 'config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nincs bejelentkezve!']);
    exit;
}

$reservation_id = $_POST['reservation_id'] ?? null;

if (!$reservation_id) {
    echo json_encode(['success' => false, 'message' => 'Hiányzó foglalás azonosító!']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        UPDATE reservations 
        SET is_canceled = 1 
        WHERE id = ? AND user_id = ?
    ");
    
    $stmt->execute([$reservation_id, $_SESSION['user_id']]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'A foglalás nem található vagy nem a felhasználóhoz tartozik!']);
    }
} catch(PDOException $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Adatbázis hiba történt!']);
}