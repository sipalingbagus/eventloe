<?php
include 'koneksi2.php'; // Koneksi ke database
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
// Ambil data event yang dibeli
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch user ID berdasarkan username
    $userQuery = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $userQuery->execute(['username' => $username]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id'];

        // Fetch data event yang dipilih
        $eventQuery = $pdo->prepare("SELECT * FROM events WHERE id = :event_id");
        $eventQuery->execute(['event_id' => $event_id]);
        $event = $eventQuery->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            $price = $event['price'];
            $tickets = 1; // Misalnya default 1 tiket per pembelian
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
            exit; // Pastikan script berhenti setelah redirect
        } else {
            echo "Event tidak ditemukan.";
        }
    } else {
        echo "User tidak ditemukan.";
    }
}

// Fetch semua event
$query = "SELECT * FROM events ORDER BY date DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background dengan gradien */
        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 50%, #fbc2eb 100%);
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        /* Tombol Back to Home */
        a.home-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #ff6f61;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a.home-btn:hover {
            background-color: #d95d56;
            transform: scale(1.1);
        }

        /* Menjaga konsistensi ukuran gambar dalam kartu */
        .card-img-top {
            height: 200px; /* Tentukan tinggi gambar tetap */
            object-fit: cover; /* Gambar akan menyesuaikan dengan area gambar tanpa merubah rasio aspek */
            width: 100%; /* Membuat lebar gambar memenuhi lebar kartu */
        }

        /* Kartu desain */
        .card {
            height: 100%; /* Memastikan kartu memiliki tinggi yang konsisten */
            display: flex;
            flex-direction: column; /* Membuat konten kartu tersusun vertikal */
        }

        /* Mengatur body kartu agar tidak meluap */
        .card-body {
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        .card-footer {
            background-color: transparent;
            border-top: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- Elemen dekoratif -->
    <div class="decorative-stripes stripe-1"></div>
    <div class="decorative-stripes stripe-2"></div>

    <!-- Tombol "Back to Home" -->
    <a href="index.php" class="home-btn">Back to Home</a>

    <div class="container mt-5">
        <h2 class="text-center mb-5">Browse Events</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col mb-4">
                        <div class="card">
                            <img src="uploads/<?= htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Gambar Event">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                                <p class="card-text"><strong>Tanggal:</strong> <?= htmlspecialchars($row['date']); ?></p>
                                <p class="card-text"><strong>Harga:</strong> Rp <?= number_format($row['price'], 2, ',', '.'); ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <form action="process_buy_event.php" method="POST">
                                    <input type="hidden" name="event_id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Beli</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col">
                    <div class="alert alert-info text-center">Belum ada event.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
