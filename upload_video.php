<?php
// Koneksi ke database
$host = 'localhost';
$db = 'login_regis';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi apakah file video diunggah
    if (!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
        die("Error: Tidak ada file video yang diupload atau terjadi masalah saat upload.");
    }

    $event_name = htmlspecialchars($_POST['event_name']);
    $description = htmlspecialchars($_POST['description']);
    $video_file = $_FILES['video'];
    $upload_dir = "uploads/videos/";
    $video_path = $upload_dir . basename($video_file['name']);

    // Cek apakah folder upload ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Pindahkan file video ke folder tujuan
    if (move_uploaded_file($video_file['tmp_name'], $video_path)) {
        // Simpan ke database
        $query = "INSERT INTO event_videos (video_url, event_name, description) VALUES (:video_url, :event_name, :description)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':video_url', $video_path);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            echo "Video berhasil diupload.";
        } else {
            echo "Error: Gagal menyimpan data ke database.";
        }
    } else {
        echo "Error: Gagal mengupload file.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(44, 58, 71); /* Light gray background */
        }
        .container {
            background-color: #ffffff; /* White background for the content */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="index3.php" class="btn btn-secondary btn-back">Back to menu</a>
       
</head>
<body>
<div class="container mt-5">
    <h2>Upload Video</h2>
    <form action="upload_video.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="video" class="form-label">Pilih Video</label>
            <input type="file" class="form-control" name="video" id="video" accept="video/*" required>
        </div>
        <div class="mb-3">
            <label for="event_name" class="form-label">Nama Event</label>
            <input type="text" class="form-control" name="event_name" id="event_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Event</label>
            <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
