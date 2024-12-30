<?php
include 'koneksi2.php'; // Pastikan file koneksi database sudah benar

// Cek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Pastikan folder uploads ada, jika tidak buat folder tersebut
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Proses upload file gambar
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Simpan data ke database
        $query = "INSERT INTO events (title, date, price, image) VALUES ('$title', '$date', '$price', '$image')";
        if (mysqli_query($conn, $query)) {
            // Jika berhasil, arahkan ke halaman manage_event.php
            header("Location: browse_events.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
} else {
    echo "Metode tidak valid.";
}
?>
