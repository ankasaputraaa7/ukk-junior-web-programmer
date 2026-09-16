<?php
session_start();
include 'koneksi.php';

$message = "";
$status_type = "";

if (isset($_POST['reset_password'])) {
    $email        = trim($_POST['email']);
    $password_baru = trim($_POST['password_baru']);
    $konfirmasi   = trim($_POST['konfirmasi_password']);

    // Validasi input
    if ($password_baru !== $konfirmasi) {
        $message = "Konfirmasi kata sandi tidak cocok!";
        $status_type = "danger";
    } else {
        $email_escaped = mysqli_real_escape_string($koneksi, $email);

        // Cek apakah email terdaftar di database (tabel karyawan) atau merupakan email admin khusus
        $cek_email = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE email = '$email_escaped'");
        
        if ($email === 'anka@gmail.com' || mysqli_num_rows($cek_email) > 0) {
            // Jika email terdaftar sebagai admin khusus (anka@gmail.com)
            if ($email === 'anka@gmail.com') {
                $_SESSION['admin_password'] = $password_baru;
            }

            $message = "Kata sandi berhasil diperbarui! Silakan login kembali.";
            $status_type = "success";
        } else {
            $message = "Email tidak terdaftar di sistem!";
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
    <title>Reset Kata Sandi - Enterprise Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
            padding: 32px;
        }
        .logo-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px auto;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 14px;
        }
        .btn-reset {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="reset-card">
    <div class="text-center mb-4">
        <div class="logo-icon">🔑</div>
        <h4 class="fw-bold text-dark mb-1">Reset Kata Sandi</h4>
        <p class="text-muted small mb-0">Masukkan email terdaftar dan kata sandi baru Anda</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $status_type; ?> py-2 px-3 small rounded-3 mb-3 text-center fw-medium">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="lupa_sandi.php" method="POST">
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Email Terdaftar</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email terdaftar" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Kata Sandi Baru</label>
            <input type="password" name="password_baru" class="form-control" placeholder="Masukkan kata sandi baru" required>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-semibold text-secondary">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi kata sandi baru" required>
        </div>

        <button type="submit" name="reset_password" class="btn btn-reset mb-3">Simpan Kata Sandi Baru</button>

        <div class="text-center">
            <a href="index.php" class="small text-primary text-decoration-none fw-semibold">← Kembali ke Halaman Login</a>
        </div>
    </form>
</div>

</body>
</html>