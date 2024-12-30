<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Futuristic Color Scheme */
        body {
            background: linear-gradient(135deg, #00aaff, #00ffaa);
            color: #f5f5f5;
        }

        .navbar {
            background-color: #2b2d42; /* Dark blue */
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-brand, .nav-link {
            font-weight: bold;
        }

        .navbar-brand {
            color: #00ffaa !important;
        }

        .nav-link {
            color: #f5f5f5 !important;
        }

        .navbar-nav .nav-item:hover .nav-link {
            color: #00aaff !important;
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #00aaff;
            border-color: #00aaff;
        }

        .btn-primary:hover {
            background-color: #00ffaa;
            border-color: #00ffaa;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        /* Scrolling Text */
        .scrolling-text {
            position: relative;
            overflow: hidden;
            background-color: #2b2d42;
            color: #fff;
        }

        .scrolling-text p {
            position: absolute;
            white-space: nowrap;
            animation: scroll-text 15s linear infinite;
            font-size: 18px;
        }

        @keyframes scroll-text {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(-100%);
            }
        }

        /* Footer */
        footer {
            background-color: #2b2d42;
            color: #f5f5f5;
            padding: 20px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer h5 {
            color: #00ffaa;
        }

        /* Content Area */
        .container {
            background-color: #222d38;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 50px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            color: #00ffaa;
        }

        .container p {
            color: #dcdcdc;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Guest View</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index2.php">Home</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn btn-primary me-2">Login</a>
                    <a href="register.php" class="btn btn-success">Register</a>
                    <a href="login.php" class="btn btn-warning me-3">Back</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <h2>Welcome, Guest!</h2>
        <p>Anda saat ini berada di mode akses tamu. Untuk menikmati fitur penuh, silakan login atau register.</p>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h5>Motivational Quotes</h5>
            <p id="quote"></p>
        </div>
        <script>
            // Array berisi quote motivasi
            const quotes = [
                "Success is not final, failure is not fatal: It is the courage to continue that counts.",
                "Don't watch the clock; do what it does. Keep going.",
                "The future belongs to those who believe in the beauty of their dreams.",
                "Keep your face always toward the sunshine—and shadows will fall behind you.",
                "Success usually comes to those who are too busy to be looking for it."
            ];

            // Fungsi untuk menampilkan quote secara acak
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            document.getElementById("quote").innerText = randomQuote;
        </script>
    </footer>

    <!-- Scrolling Text -->
    <div class="scrolling-text py-2">
        <div class="container text-center">
            <p class="mb-0">Selamat datang di website kami! Nikmati berbagai event menarik dan jadikan momen tak terlupakan! 🎉</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
