<?php
require 'koneksi2.php'; // File koneksi database
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Ambil user ID berdasarkan username
    $userQuery = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $userQuery->execute(['username' => $username]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id'];

        // Ambil data event berdasarkan ID
        $eventQuery = $pdo->prepare("SELECT * FROM events WHERE id = :event_id");
        $eventQuery->execute(['event_id' => $event_id]);
        $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            // Menghitung total harga berdasarkan jumlah tiket (asumsikan 1 tiket)
            $price = $event['price'];
            $tickets = 1;
            $total_price = $price * $tickets;
            $purchase_date = date('Y-m-d H:i:s');

            // Simpan data pembelian ke tabel purchased_event
            $purchaseQuery = $pdo->prepare("
                INSERT INTO purchased_event (user_id, event_id, tickets, total_price, purchase_date, payment_status)
                VALUES (:user_id, :event_id, :tickets, :total_price, :purchase_date, 'Belum Lunas')
            ");
            $purchaseQuery->execute([
                'user_id' => $user_id,
                'event_id' => $event_id,
                'tickets' => $tickets,
                'total_price' => $total_price,
                'purchase_date' => $purchase_date
            ]);

            // Redirect ke halaman purchased_event.php setelah pembelian sukses
            header("Location: purchased_event.php");
            exit;
        }
    }
}

// Ambil event yang telah dibeli
$stmt = $pdo->prepare("
    SELECT e.title, e.price, p.tickets, p.total_price, p.purchase_date, p.payment_status
    FROM purchased_event p
    JOIN events e ON p.event_id = e.id
    JOIN users u ON p.user_id = u.id
    WHERE u.username = :username
");
$stmt->execute(['username' => $username]);
$purchasedEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Purchased Events</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul Event</th>
                    <th>Harga</th>
                    <th>Tiket</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($purchasedEvents) > 0): ?>
                    <?php foreach ($purchasedEvents as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['title']); ?></td>
                            <td>Rp <?= number_format($event['price'], 2, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($event['tickets']); ?></td>
                            <td>Rp <?= number_format($event['total_price'], 2, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($event['purchase_date']); ?></td>
                            <td><?= htmlspecialchars($event['payment_status']); ?></td>
                            <td>
                                <?php if ($event['payment_status'] === 'Belum Lunas'): ?>
                                    <form method="POST" action="purchased_event.php">
                                        <input type="hidden" name="purchase_id" value="<?= $event['purchase_id']; ?>">
                                        <button type="submit" name="pay" class="btn btn-success">Lunas</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Anda belum membeli event apapun.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
