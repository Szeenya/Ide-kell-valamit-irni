<?php
require_once 'models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register($username, $email, $password, $confirm_password) {
        // Eltávolítjuk az átirányítást
        return $this->userModel->register($username, $email, $password, $confirm_password);
    }

    public function login($email, $password) {
        $user = $this->userModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true; // Sikeres bejelentkezés
        }
<<<<<<< Updated upstream
        
=======

>>>>>>> Stashed changes
        return "Hibás email cím vagy jelszó!"; // Hibaüzenet
    }
}