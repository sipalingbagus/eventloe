<?php
$host = 'localhost'; // Nama host
$db = 'login_regis'; // Ganti dengan nama database Anda
$user = 'root'; // Username default XAMPP
$pass = ''; // Password default XAMPP (kosong)

// Koneksi menggunakan PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Koneksi menggunakan mysqli
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
if (!isset($pdo) || !isset($conn)) {
    die("Koneksi belum terinisialisasi dengan benar.");
}
?>