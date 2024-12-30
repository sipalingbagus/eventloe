<?php
include 'koneksi2.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil saldo pengguna
try {
    $balanceQuery = $pdo->prepare("SELECT balance FROM users WHERE username = :username");
    $balanceQuery->execute(['username' => $username]);
    $user = $balanceQuery->fetch(PDO::FETCH_ASSOC);
    $balance = $user['balance'] ?? 0;
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}

// Tambah Saldo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_balance'])) {
    $add_balance = (double)$_POST['add_balance'];

    if ($add_balance > 0) {
        try {
            $updateBalanceQuery = $pdo->prepare("
                UPDATE users SET balance = balance + :add_balance WHERE username = :username
            ");
            $updateBalanceQuery->execute([
                'add_balance' => $add_balance,
                'username' => $username,
            ]);

            header("Location: purchased_event.php");
            exit;
        } catch (PDOException $e) {
            echo "Kesalahan: " . $e->getMessage();
        }
    } else {
        echo "Saldo yang ditambahkan harus lebih dari 0.";
    }
}

// Ambil daftar event yang telah dibeli
try {
    $stmt = $pdo->prepare("
        SELECT p.id, e.title AS event_title, e.price AS event_price, p.tickets, p.total_price, p.purchase_date, p.payment_status
        FROM purchased_event p
        JOIN events e ON p.event_id = e.id
        JOIN users u ON p.user_id = u.id
        WHERE u.username = :username
    ");
    $stmt->execute(['username' => $username]);
    $purchasedEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}
// Ambil daftar event yang sudah dilunasi
try {
    $paidStmt = $pdo->prepare("
        SELECT p.id, e.title AS event_title, e.price AS event_price, p.tickets, p.total_price, p.purchase_date, p.payment_status
        FROM purchased_event p
        JOIN events e ON p.event_id = e.id
        JOIN users u ON p.user_id = u.id
        WHERE u.username = :username AND p.payment_status = 'Lunas'
    ");
    $paidStmt->execute(['username' => $username]);
    $paidEvents = $paidStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kesalahan: " . $e->getMessage();
}

// Proses pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase_id'])) {
    $purchase_id = $_POST['purchase_id'];

    // Ambil total harga event
    $eventQuery = $pdo->prepare("
        SELECT total_price FROM purchased_event WHERE id = :purchase_id
    ");
    $eventQuery->execute(['purchase_id' => $purchase_id]);
    $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $total_price = $event['total_price'];

        if ($balance >= $total_price) {
            try {
                $pdo->beginTransaction();

                // Kurangi saldo
                $updateBalanceQuery = $pdo->prepare("
                    UPDATE users SET balance = balance - :total_price WHERE username = :username
                ");
                $updateBalanceQuery->execute([
                    'total_price' => $total_price,
                    'username' => $username,
                ]);

                // Update status pembayaran
                $updatePaymentQuery = $pdo->prepare("
                    UPDATE purchased_event SET payment_status = 'Lunas' WHERE id = :purchase_id
                ");
                $updatePaymentQuery->execute(['purchase_id' => $purchase_id]);

                $pdo->commit();

                // Simpan pesan notifikasi
                $_SESSION['notification'] = "Tiket online Anda akan dikirimkan melalui email dalam waktu 24 jam.";

                header("Location: purchased_event.php");
                exit;
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "Kesalahan: " . $e->getMessage();
            }
        } else {
            echo "Saldo Anda tidak mencukupi untuk melunasi event ini.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        h2.text-center {
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .balance-wrapper {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-wrapper {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        button.btn-success {
            background-color: #28a745;
            border: none;
        }

        button.btn-success:hover {
            background-color: #218838;
        }

        .back-buttons {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .back-buttons a {
            text-decoration: none;
            color: white;
        }
    </style>
    <script>
        function confirmPayment(eventId) {
            if (confirm("Lunasi event ini?")) {
                document.getElementById("paymentForm-" + eventId).submit();
            }
        }
    </script>
</head>
<body>
    <!-- Tombol Navigasi di Pojok Kiri Atas -->
    <div class="back-buttons">
        <a href="index.php" class="btn btn-success">Back to Home</a>
        <a href="browse_events.php" class="btn btn-success">Back to Browse Event</a>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Purchased Events</h2>

        <!-- Tampilkan Saldo -->
        <div class="balance-wrapper mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Saldo Anda: Rp <?= number_format($balance, 2, ',', '.'); ?></h4>
                <form method="POST" class="d-flex">
                    <input type="number" name="add_balance" class="form-control me-2" placeholder="Tambah Saldo" min="1" required>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
<!-- Modal untuk Notifikasi -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">Notifikasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="notificationMessage"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_SESSION['notification'])): ?>
            // Ambil pesan notifikasi dari session
            const notificationMessage = "<?= htmlspecialchars($_SESSION['notification']); ?>";
            
            // Masukkan pesan ke modal
            document.getElementById('notificationMessage').innerText = notificationMessage;
            
            // Tampilkan modal
            const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
            notificationModal.show();
            
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>
    });
</script>

        <!-- Daftar Event -->
        <div class="table-wrapper">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
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
                                <td><?= htmlspecialchars($event['event_title']); ?></td>
                                <td>Rp <?= number_format($event['event_price'], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($event['tickets']); ?></td>
                                <td>Rp <?= number_format($event['total_price'], 2, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($event['purchase_date']); ?></td>
                                <td><?= htmlspecialchars($event['payment_status']); ?></td>
                                <td>
                                    <?php if ($event['payment_status'] === 'Belum Lunas'): ?>
                                        <form id="paymentForm-<?= $event['id']; ?>" method="POST" style="display: inline;">
                                            <input type="hidden" name="purchase_id" value="<?= $event['id']; ?>">
                                            <button type="button" class="btn btn-success" onclick="confirmPayment(<?= $event['id']; ?>)">Lunas</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>Lunas</button>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
