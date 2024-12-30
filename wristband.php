<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tipe Tiket Gelang</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(216, 119, 119);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .content {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 70%;
            max-width: 800px;
        }

        .image-container {
            position: relative;
            margin-bottom: 30px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .features {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .feature {
            text-align: center;
            width: 48%;
        }

        .feature h5 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .feature p {
            font-size: 1rem;
            line-height: 1.5;
            color: #666;
        }

        .details {
            display: flex;
            justify-content: space-between;
        }

        .detail {
            width: 48%;
            margin-bottom: 20px;
        }

        .detail h6 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #333;
        }

        .detail p {
            font-size: 0.9rem;
            color: #666;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* Custom Styles for "Back to Home" Button */
        a.btn {
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

        a.btn:hover {
            background-color: darkred;
            transform: scale(1.1); /* Button enlarge on hover */
        }
    </style>
</head>
<body>
    <!-- Tombol "Back" di pojok kiri atas -->
    <a href="index.php" class="btn">Back to Home</a>

    <div class="container">
        <div class="content">
            <h1>Referensi Tiket Gelang buat Event Loe</h1>
            <div class="image-container">
                <img src="wristband.jpeg" alt="Wristband Image">
            </div>
            <div class="features">
                <div class="feature">
                    <h5>Tipe A</h5>
                    <p>- Menggunakan QR code.</p>
                </div>
                <div class="feature">
                    <h5>Tipe B</h5>
                    <p>- Tanpa menggunakan QR code.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
