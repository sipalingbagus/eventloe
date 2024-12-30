<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Register</h2>
            <form method="POST" action="process_register.php" onsubmit="return validatePasswords()">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye-slash" id="toggle-icon-password"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3 position-relative">
                    <label for="re_password" class="form-label">Re-enter Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="re_password" name="re_password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('re_password', this)">
                            <i class="bi bi-eye-slash" id="toggle-icon-re_password"></i>
                        </button>
                    </div>
                </div>
                <div id="error-message" class="text-danger mb-3" style="display: none;"></div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value;
            const rePassword = document.getElementById('re_password').value;
            const errorMessage = document.getElementById('error-message');

            if (password !== rePassword) {
                errorMessage.textContent = "Password tidak cocok. Silakan periksa kembali.";
                errorMessage.style.display = "block";
                return false;
            }

            errorMessage.style.display = "none";
            return true;
        }

        function togglePassword(inputId, toggleButton) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = toggleButton.querySelector('i');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            }
        }
    </script>
</body>
</html>
