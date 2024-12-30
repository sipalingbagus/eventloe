<?php
include 'koneksi2.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $username = $_SESSION['username'];
    $event_id = $_POST['event_id'];

    try {
        // Ambil user ID berdasarkan username
        $userQuery = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $userQuery->execute(['username' => $username]);
        $user = $userQuery->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_id = $user['id'];

            // Ambil data event
            $eventQuery = $pdo->prepare("SELECT * FROM events WHERE id = :event_id");
            $eventQuery->execute(['event_id' => $event_id]);
            $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

            if ($event) {
                $price = $event['price'];
                $tickets = 1; // Default satu tiket
                $total_price = $price * $tickets;
                $purchase_date = date('Y-m-d H:i:s');

                // Masukkan ke tabel purchased_event
                $purchaseQuery = $pdo->prepare("
                    INSERT INTO purchased_event 
                    (user_id, event_id, tickets, total_price, purchase_date, payment_status)
                    VALUES (:user_id, :event_id, :tickets, :total_price, :purchase_date, 'Belum Lunas')
                ");
                $purchaseQuery->execute([
                    'user_id' => $user_id,
                    'event_id' => $event_id,
                    'tickets' => $tickets,
                    'total_price' => $total_price,
                    'purchase_date' => $purchase_date
                ]);

                // Redirect ke purchased_event.php
                header("Location: purchased_event.php");
                exit;
            } else {
                echo "Event tidak ditemukan.";
            }
        } else {
            echo "User tidak ditemukan.";
        }
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}
?>
