<?php
include 'koneksi2.php'; // Pastikan file koneksi database

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Query untuk menghapus event berdasarkan ID
    $query = "DELETE FROM events WHERE id = $event_id";
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, kembali ke halaman manage events
        header('Location: manage_events.php');
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "ID event tidak ditemukan.";
}
?>
