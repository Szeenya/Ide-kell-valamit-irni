<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function register($username, $email, $password, $confirm_password) {
        // Jelszó egyezés ellenőrzése
        if ($password !== $confirm_password) {
            return ['error' => 'A jelszavak nem egyeznek!'];
        }

        // Jelszó komplexitás ellenőrzése
        if (strlen($password) < 8) {
            return ['error' => 'A jelszónak legalább 8 karakterből kell állnia!'];
        }

        if (!preg_match("/[A-Z]/", $password)) {
            return ['error' => 'A jelszónak tartalmaznia kell legalább egy nagybetűt!'];
        }

        if (!preg_match("/[0-9]/", $password)) {
            return ['error' => 'A jelszónak tartalmaznia kell legalább egy számot!'];
        }

        // Felhasználónév és email ellenőrzése
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['username'] === $username) {
                return ['error' => 'Ez a felhasználónév már foglalt!'];
            }
            if ($user['email'] === $email) {
                return ['error' => 'Ez az email cím már regisztrálva van!'];
            }
        }

        // Ha minden rendben, regisztráljuk a felhasználót
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['error' => 'Hiba történt a regisztráció során!'];
        }
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }
}