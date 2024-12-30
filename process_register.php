<?php
include 'koneksi2.php';

session_start(); // Mulai session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if ($password !== $re_password) {
        echo "Password tidak cocok! Silakan kembali dan coba lagi.";
        exit;
    }

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        // Simpan username ke session setelah register berhasil
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        echo "Registrasi gagal: " . mysqli_error($conn);
    }
}
?>
