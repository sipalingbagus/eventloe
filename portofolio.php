<?php
// Koneksi ke database menggunakan PDO
$host = 'localhost'; // Nama host
$db = 'login_regis'; // Nama database Anda
$user = 'root'; // Username database
$pass = ''; // Password database

// Membuat koneksi menggunakan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode untuk menangkap error
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Ambil semua data video yang telah diunggah
$query = "SELECT * FROM event_videos ORDER BY upload_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #d4e6f1 0%, #aed6f1 100%);
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #d1eaf5;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
        }

        .card-text {
            font-size: 0.9rem;
            color: #566573;
        }

        .back-buttons {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .back-buttons a {
            text-decoration: none;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        h2 {
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            color: #154360;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Tombol Navigasi di Pojok Kiri Atas -->
    <div class="back-buttons">
        <a href="index.php" class="btn btn-danger">Back to Home</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Portofolio Video</h2>
        <?php if (count($videos) > 0): ?>
            <div class="row">
                <?php foreach ($videos as $video): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($video['event_name']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($video['description']); ?></p>
                                <video width="100%" controls autoplay muted>
                                    <source src="<?= htmlspecialchars($video['video_url']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <p class="text-muted"><?= $video['upload_date']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Belum ada video yang diunggah.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
