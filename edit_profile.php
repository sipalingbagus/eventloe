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

        // Update data pengguna di database
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
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Gradien latar belakang */
            color: #333;
            font-family: 'Arial', sans-serif;
        }

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

        a.home-btn:hover {
            background-color: darkred;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Tombol "Home" di pojok kiri atas -->
    <a href="profile.php" class="home-btn">back to profile</a>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Profile</h1>

        <?php if (isset($user)): ?>
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Edit Profile</h3>
                </div>
                <div class="card-body">
                    <form action="edit_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">About Me</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="update_profile">Update Profile</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">Profil tidak ditemukan.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
