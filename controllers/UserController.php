<?php
require_once 'models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register($username, $email, $password, $confirm_password) {
        $errors = [];

        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }

        if (empty($errors)) {
            if ($this->userModel->register($username, $email, $password)) {
                $_SESSION['success'] = "Registration successful!";
                header("Location: index.php?action=login");
                exit();
            } else {
                $errors[] = "Registration failed";
            }
        }

        return $errors;
    }

    public function login($email, $password) {
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php?action=dashboard");
            exit();
        }
        
        return "Invalid email or password";
    }
}