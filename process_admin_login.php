<?php
session_start();
require_once 'koneksi2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memeriksa data admin
    $query = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        // Login berhasil
        $_SESSION['admin'] = $username;
        header("Location: index3.php");
        exit;
    } else {
        // Login gagal
        $_SESSION['error'] = "Username atau Password salah!";
        header("Location: admin_login.php");
        exit;
    }
} else {
    // Akses langsung ke file ini
    header("Location: admin_login.php");
    exit;
}
?>
