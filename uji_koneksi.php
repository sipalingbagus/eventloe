<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Ganti dengan password MySQL Anda
$db = 'login_regis';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil!";
?>
