<?php
session_start();
require 'koneksi2.php'; // Pastikan file koneksi2.php sudah benar

// Ambil username dari sesi login
$username = $_SESSION['username'] ?? null;

if ($username) {
    // Ambil data profil dari database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Update profil
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $bio = $_POST['bio'];

        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, bio = :bio WHERE username = :username");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'bio' => $bio,
            'username' => $username
        ]);
        header("Location: profile.php");
        exit;
    }
} else {
    echo "Anda belum login. Silakan login terlebih dahulu.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a.home-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: red;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        body {
        background: linear-gradient(135deg,rgb(242, 115, 115),rgb(227, 128, 128)); /* Gradien dari merah muda ke oranye */
        color: #333;
        font-family: 'Arial', sans-serif;
        }

        a.home-btn:hover {
            background-color: darkred;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Tombol "Home" di pojok kiri atas -->
    <a href="index.php" class="home-btn">Home</a>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Profile</h1>
        <?php if (isset($user)): ?>
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-header bg-primary text-white text-center">
                    <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                </div>
                <div class="card-body">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>About Me:</strong></p>
                    <p class="text-muted"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                    <hr>
                    <p class="text-secondary"><small>Last updated: <?php echo date("d F Y, H:i", strtotime($user['updated_at'] ?? 'now')); ?></small></p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="edit_profile.php" class="btn btn-warning">Edit Profile</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Profil tidak ditemukan.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
