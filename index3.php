<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "Session admin tidak ditemukan. Redirect ke login.";
    header("Location: admin_login.php");
    exit;
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color:rgb(243, 239, 242);
        }

        .content {
            flex: 1;
        }

        .navbar {
            background: linear-gradient(90deg,rgb(2, 2, 2), #283e51);
        }

        footer {
            background-color:rgb(0, 0, 0);
            color: white;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card.border-primary {
            background: linear-gradient(135deg,rgb(0, 0, 0),rgb(2, 2, 2));
            color: white;
        }

        .card.border-success {
            background: linear-gradient(135deg,rgb(0, 0, 0),rgb(0, 0, 0));
            color: white;
        }

        .card.border-warning {
            background: linear-gradient(135deg,rgb(0, 0, 0),rgb(0, 0, 0));
            color: white;
        }

        .container {
            background-color:rgb(178, 103, 121);
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .btn-back {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger btn-sm ms-3">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content">
        <div class="container mt-5">
            <div class="text-center">
                <h1 class="display-4">Welcome, <?= htmlspecialchars($_SESSION['admin']); ?>!</h1>
                <p class="lead">This is your admin dashboard. Manage your activities effectively.</p>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title">Manage Events</h5>
                            <p class="card-text">Organize and update events effortlessly.</p>
                            <a href="manage_events.php" class="btn btn-light">Go to Events</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="card-title">Upload Videos</h5>
                            <p class="card-text">Upload and manage your video content here.</p>
                            <a href="upload_video.php" class="btn btn-light">Upload Video</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h5 class="card-title">Manage Users</h5>
                            <p class="card-text">Control and monitor registered users.</p>
                            <a href="manage_users.php" class="btn btn-light">Manage Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3">
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </footer>

    <a href="login.php" class="btn btn-secondary btn-sm btn-back">Back to Login</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
