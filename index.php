<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Enterprise Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }
        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .btn-custom-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 56px; height: 56px; font-size: 24px;">💼</div>
        <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
        <p class="text-muted small">Silakan masuk ke Portal Manajemen Karyawan</p>
    </div>
    
    <form action="dashboard.php" method="GET">
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Email / Username</label>
            <input type="text" class="form-control" placeholder="nama@perusahaan.co.id" required>
        </div>
        
        <div class="mb-4">
            <div class="d-flex justify-content-between">
                <label class="form-label small fw-semibold text-secondary">Kata Sandi</label>
                <a href="#" class="small text-decoration-none fw-semibold" style="color: #2563eb;">Lupa sandi?</a>
            </div>
            <input type="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-custom-primary w-100">Masuk ke Dashboard</button>
    </form>
</div>

</body>
</html>