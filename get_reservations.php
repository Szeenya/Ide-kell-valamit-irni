<?php
session_start();
require_once 'config/config.php';
require_once 'models/SuitModel.php';

header('Content-Type: application/json');

if (!isset($_GET['suit_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing suit ID']);
    exit;
}

$suitModel = new SuitModel();
$reservations = $suitModel->getReservations($_GET['suit_id']);

echo json_encode(['success' => true, 'reservations' => $reservations]);