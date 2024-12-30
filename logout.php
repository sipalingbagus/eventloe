<?php
// Mulai session
session_start();
session_destroy();
header("Location: index2.php"); // Arahkan kembali ke halaman guest



// Hapus semua data session
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit;
?>
