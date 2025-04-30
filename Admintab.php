<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Foglalások</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/style/main_style.css">
    <link rel="stylesheet" href="src/style/navbar.css">
    <link rel="stylesheet" href="src/style/admin_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    session_start();
    require_once 'config/config.php';

    // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve és admin-e
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }

    // Admin jogosultság ellenőrzése
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $is_admin = (bool)$stmt->fetchColumn();

    if (!$is_admin) {
        header("Location: home.php");
        exit();
    }

    include 'navbar.php';

    // Foglalások lekérése az adatbázisból
    try {
        $sql = "SELECT r.*, u.username, u.email, s.type as suit_type 
                FROM reservations r 
                JOIN users u ON r.user_id = u.id 
                JOIN suits s ON r.suit_id = s.id
                ORDER BY r.added_at DESC";
        $stmt = $pdo->query($sql);
    } catch(PDOException $e) {
        echo "Hiba történt: " . $e->getMessage();
        exit();
    }
    ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Aktív Foglalások Kezelése</h2>
        
        <div class="row">
            <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                // Státusz meghatározása
                $status = "Aktív";
                $statusClass = "text-success";
                
                if (isset($row['is_canceled']) && $row['is_canceled'] == 1) {
                    $status = "Lemondott";
                    $statusClass = "text-danger";
                } else {
                    $currentDate = new DateTime();
                    $endDate = new DateTime($row['rented_until']);
                    
                    if ($endDate < $currentDate) {
                        $status = "Lejárt";
                        $statusClass = "text-warning";
                    }
                }
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Foglalás #<?php echo $row['id']; ?></h5>
                            <p class="card-text">
                                <strong>Felhasználó:</strong> <?php echo htmlspecialchars($row['username']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?><br>
                                <strong>Öltöny típusa:</strong> <?php echo htmlspecialchars($row['suit_type']); ?><br>
                                <strong>Bérlés kezdete:</strong> <?php echo date('Y-m-d', strtotime($row['rented_from'])); ?><br>
                                <strong>Bérlés vége:</strong> <?php echo date('Y-m-d', strtotime($row['rented_until'])); ?><br>
                                <strong>Foglalás időpontja:</strong> <?php echo date('Y-m-d H:i', strtotime($row['added_at'])); ?><br>
                                <strong>Státusz:</strong> <span class="<?php echo $statusClass; ?>"><?php echo $status; ?></span>
                            </p>
                            <form action="delete_reservation.php" method="POST" onsubmit="return confirm('Biztosan törli ezt a foglalást?');">
                                <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger w-100">Foglalás törlése</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>