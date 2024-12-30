<?php
session_start();
require 'koneksi2.php'; 

// Cek apakah pengguna sudah login, jika belum, redirect ke login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION['username'])) {
    header("Location: index2.php");
    exit;
}
$username = $_SESSION['username'];

// Logika pencarian
// Logika pencarian
$searchResults = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchQuery = $_POST['search'];

    // Pastikan kolom `description` benar-benar ada di tabel
    $stmt = $pdo->prepare("SELECT * FROM events WHERE title LIKE :query OR description LIKE :query");
    $stmt->execute(['query' => '%' . $searchQuery . '%']);
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            transition: background-color 0.5s ease;
        }
        .navbar-brand img {
            width: 50px;
            height: auto;
            .navbar-nav .dropdown-menu {
    background-color: #343a40;
}

.navbar-nav .dropdown-item {
    color: white;
}

.navbar-nav .dropdown-item:hover {
    background-color: #495057;
}
</style>
        
    </style>
</head>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Welcome, <?php echo htmlspecialchars($username); ?>!</a>
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="indooo.png" alt="Indonesia Logo">
                <span class="ms-4">| Event Loe | ID</span>
                </a>
                 <!-- Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </a>
                     <!-- Navbar Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> <!-- ms-auto untuk memindahkan ke kanan -->
                    <li class="nav-item">
                        <a class="nav-link" href="wristband.php">contoh wristband</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"> Your Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panduan_event_creator.php">Panduan Event Creator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="biaya_layanan.php">Biaya Layanan</a>
                    </li>
            </ul>
            <div class="d-flex">
            <form class="d-flex me-auto ms-1" method="POST" action="">
            <button class="btn btn-outline-light" type="submit">Search</button>
                <input class="form-control me-5" type="search" name="search" placeholder="cari event loe..." aria-label="Search"> 
               
            </form>
                <a href="logout.php" class="btn btn-danger">Logout</a>
                
            </div>
        </div>
    </nav>
     <!-- Hasil Pencarian -->
     <div class="container mt-5">
    <?php
    // Tambahkan variabel flag pencarian
    $searchPerformed = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $searchPerformed = true;
    }
    ?>
    <?php if (!empty($searchResults)): ?>
        <h2 class="text-center">Hasil Pencarian untuk "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
        <div class="row">
            <?php foreach ($searchResults as $event): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow">
                        <img src="<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                            <a href="browse_events.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">beli di menu browse event</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($searchPerformed): ?>
        <script>
            alert("Event tidak ditemukan.");
        </script>
    <?php endif; ?>
</div>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
            
        </div>
    </div>
</nav>

    <!-- Banner Slider -->
    <div id="eventSlider" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="event.png" class="d-block w-100" alt="Event 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>EVENT LOE?</h5>
                    <p>Experience the best live and event music!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="yoyo1.jpeg" class="d-block w-100" alt="Event 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Festival of Lights</h5>
                    <p>Immerse yourself in dazzling lights.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="yoyo3.jpeg" class="d-block w-100" alt="Event 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Jazz Evening</h5>
                    <p>Relax with soulful jazz music.</p>
                </div>
                </div>
                <div class="carousel-item">
                <img src="bts.png" class="d-block w-100" alt="Event 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>THIS IS BTS</h5>
                    <p>BTS world tour.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Background Color Changer -->
    <div class="container mt-5 text-center">
        <h2>mau ubah warna background biar ga boring?</h2>
        <input type="color" id="bgColorPicker" class="form-control w-25 mx-auto mt-3">
        <button id="applyBgColor" class="btn btn-primary mt-3">Apply Color</button>
    </div>

    <!-- Dashboard -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Ini menu buat Loe!</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Browse Events</h5>
                        <p class="card-text">Temukan konser favoritmu yang ter-up-to-date.</p>
                        <a href="browse_events.php" class="btn btn-primary">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Our Portfolio</h5> <!-- Mengubah judul menjadi Portfolio -->
                    <p class="card-text">After Movie dari event-event yang telah berlalu.</p>
                    <a href="portofolio.php" class="btn btn-primary">View Portfolio</a> <!-- Ganti link ke portfolio.php -->
                </div>
            </div>
        </div>
            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5 class="card-title">Purhased event</h5>
                        <p class="card-text">Bayar event yang mau kamu tonton.</p>
                        <a href="purchased_event.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 pt-3 pb-3">
        <div class="container">
            <div class="row">
                <!-- About -->
                <div class="col-md-3">
                    <h5>About</h5>
                    <p>This website provides information about various concerts and events. Stay tuned for the best entertainment!</p>
                </div>

                <!-- Information -->
                <div class="col-md-3">
                    <h5>Information</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white">bussines : (+62)86554323889 (nina)</a></li>
                        <li><a href="#" class="text-white">Help Center : 11122  </a></li>
                        <li><a href="#" class="text-white">syarat ketentuan berlaku.</a></li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                   
                        <li><a href="https://facebook.com" target="_blank" class="text-white">Facebook</a></li>
                        <li><a href="https://twitter.com" target="_blank" class="text-white">Twitter</a></li>
                        <li><a href="https://instagram.com" target="_blank" class="text-white">Instagram</a></li>
                    </ul>
                </div>

            
                <div class="col-md-3">
                <h5>kategori</h5>
                <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Festival</a></li>
                        <li><a href="#" class="text-white">Gigs</a></li>
                        <li><a href="#" class="text-white">Charity Events</a></li>
                    </ul>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['username'])): ?>
        <!-- Menu untuk user yang login -->
    <?php else: ?>
        <!-- Menu terbatas untuk guest -->
    <?php endif; ?>
    
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; 2024 event loe. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for changing background color
        const colorPicker = document.getElementById('bgColorPicker');
        const applyButton = document.getElementById('applyBgColor');

        applyButton.addEventListener('click', () => {
            const selectedColor = colorPicker.value;
            document.body.style.backgroundColor = selectedColor;
        });
    </script>
</body>
</html>
