<?php
session_start();
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservation_id'])) {
    $reservation_id = intval($_POST['reservation_id']);
    
    try {
        // Teljes törlés az adatbázisból
        $sql = "DELETE FROM reservations WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$reservation_id]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: Admintab.php?success=1");
        } else {
            header("Location: Admintab.php?error=1");
        }
    } catch(PDOException $e) {
        error_log($e->getMessage());
        header("Location: Admintab.php?error=1");
    }
} else {
    header("Location: Admintab.php");
}