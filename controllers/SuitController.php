<?php
require_once 'models/SuitModel.php';

class SuitController {
    private $suitModel;

    public function __construct() {
        $this->suitModel = new SuitModel();
    }

    public function getSuits() {
        return $this->suitModel->getAllSuits();
    }
}