<?php
session_start();
include 'koneksi.php';

$message = "";
$status_type = "";

if (isset($_POST['register'])) {
    $nama      = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $email     = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password  = trim($_POST['password']);

    // Cek apakah email sudah terdaftar
    $cek_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $message = "Email sudah terdaftar! Gunakan email lain atau langsung login.";
        $status_type = "danger";
    } else {
        // Simpan data akun baru ke database
        $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($koneksi, $query)) {
            $message = "Akun berhasil terdaftar! Silakan login.";
            $status_type = "success";
        } else {
            $message = "Gagal mendaftarkan akun: " . mysqli_error($koneksi);
            $status_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Enterprise Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .reg-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); width: 100%; max-width: 400px; padding: 32px; }
        .logo-icon { width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 16px auto; }
        .form-control { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 14px; }
        .btn-reg { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; font-weight: 600; border: none; border-radius: 10px; padding: 12px; width: 100%; font-size: 14px; }
    </style>
</head>
<body>

<div class="reg-card">
    <div class="text-center mb-4">
        <div class="logo-icon">📝</div>
        <h4 class="fw-bold text-dark mb-1">Buat Akun Baru</h4>
        <p class="text-muted small mb-0">Daftarkan akun untuk mengakses Portal Penggajian</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $status_type; ?> py-2 px-3 small rounded-3 mb-3 text-center fw-medium">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Email Terdaftar</label>
            <input type="email" name="email" class="form-control" placeholder="email@perusahaan.co.id" required>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-semibold text-secondary">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" name="register" class="btn btn-reg mb-3">Daftar Akun</button>

        <div class="text-center">
            <a href="index.php" class="small text-primary text-decoration-none fw-semibold">← Sudah Punya Akun? Login</a>
        </div>
    </form>
</div>

</body>
</html>