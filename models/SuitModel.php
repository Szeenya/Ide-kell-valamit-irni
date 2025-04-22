<?php
class SuitModel {
    private $pdo;

    public function __construct() {
        try {
            require_once 'config/config.php';
            global $pdo;
            $this->pdo = $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllSuits() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, type, color, neck, sleve, waist, 
                       chest, amount, price 
                FROM suits 
                WHERE amount > 0
                ORDER BY id DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching suits: " . $e->getMessage());
        }
    }

    public function getReservations($suitId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT rented_from, rented_until 
                FROM shopping_cart 
                WHERE suit_id = ?
            ");
            $stmt->execute([$suitId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}