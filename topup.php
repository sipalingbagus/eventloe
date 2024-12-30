<?php
session_start();
include 'koneksi2.php';

if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    // Tambahkan saldo ke akun pengguna
    $query = "UPDATE users SET saldo = saldo + ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $amount, $userId);
    $stmt->execute();

    echo "Saldo berhasil ditambahkan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Saldo</title>
</head>
<body>
    <form method="post">
        <label for="amount">Jumlah Top-Up:</label>
        <input type="number" name="amount" id="amount" min="0" required>
        <button type="submit">Top-Up</button>
    </form>
</body>
</html>
