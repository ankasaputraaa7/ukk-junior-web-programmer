<?php
session_start();
include 'koneksi.php';

$error_message = "";

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Cek keberadaan user di database
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        
        // Verifikasi password (cocokkan teks langsung atau hash)
        if ($password === $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['login_user'] = $user['email'];
            $_SESSION['nama_user']  = $user['nama'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Email atau password salah!";
        }
    } else {
        $error_message = "Akun belum terdaftar di sistem!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Enterprise Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); width: 100%; max-width: 400px; padding: 32px; }
        .logo-icon { width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto; }
        .form-control { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 14px; }
        .btn-login { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; font-weight: 600; border: none; border-radius: 10px; padding: 12px; width: 100%; font-size: 14px; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="logo-icon">💼</div>
        <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
        <p class="text-muted small mb-0">Silakan masuk ke Portal Manajemen Karyawan</p>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3 text-center fw-medium">
            ⚠️ <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Email / Username</label>
            <input type="email" name="email" class="form-control" placeholder="Email atau Username" required autofocus>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label small fw-semibold text-secondary mb-0">Kata Sandi</label>
                <a href="lupa_sandi.php" class="small text-primary text-decoration-none fw-semibold">Lupa sandi?</a>
            </div>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" name="login" class="btn btn-login mb-3">Masuk ke Dashboard</button>
        
        <div class="text-center">
            <span class="small text-muted">Belum punya akun? </span>
            <a href="register.php" class="small text-primary text-decoration-none fw-bold">Daftar Akun Baru</a>
        </div>
    </form>
</div>

</body>
</html>