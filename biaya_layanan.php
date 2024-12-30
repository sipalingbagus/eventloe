<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biaya Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a.home-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: red;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        body {
        background: linear-gradient(135deg,rgb(242, 115, 115),rgb(227, 128, 128)); /* Gradien dari merah muda ke oranye */
        color: #333;
        font-family: 'Arial', sans-serif;
        }
        a.home-btn:hover {
            background-color: darkred;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <!-- Tombol "Back to Home" di pojok kiri atas -->
    <a href="index.php" class="home-btn">Back to Home</a>

    <div class="container mt-5">
        <h1 class="text-center">Biaya Layanan</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Jenis Layanan</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Event Premium</td>
                    <td>Promosi khusus dengan fitur premium.</td>
                    <td>Rp 500.000</td>
                </tr>
                <tr>
                    <td>Event Standard</td>
                    <td>Layanan promosi dasar.</td>
                    <td>Rp 200.000</td>
                </tr>
                <tr>
                    <td>Event Gratis</td>
                    <td>Daftar acara gratis tanpa promosi.</td>
                    <td>Gratis</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
