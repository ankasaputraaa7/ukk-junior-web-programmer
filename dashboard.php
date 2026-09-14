<?php
include 'koneksi.php';

// Proses Update Gaji Pokok Karyawan dari Halaman Slip Gaji
if (isset($_POST['update_gaji'])) {
    $id_karyawan = mysqli_real_escape_string($koneksi, $_POST['id_karyawan']);
    $gaji_pokok  = mysqli_real_escape_string($koneksi, $_POST['gaji_pokok']);

    $query_update = "UPDATE karyawan SET gaji_pokok = '$gaji_pokok' WHERE id = '$id_karyawan'";
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Data Gaji Berhasil Diperbarui di Database!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Proses Simpan Data Karyawan Baru
if (isset($_POST['tambah_karyawan'])) {
    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nik        = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $email      = mysqli_real_escape_string($koneksi, $_POST['email']);
    $jabatan    = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $gaji_pokok = mysqli_real_escape_string($koneksi, $_POST['gaji_pokok']);

    $query = "INSERT INTO karyawan (nama, nik, email, jabatan, gaji_pokok) 
              VALUES ('$nama', '$nik', '$email', '$jabatan', '$gaji_pokok')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Karyawan Berhasil Ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal Menambahkan Karyawan: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Proses Hapus Data Karyawan
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $query_hapus = "DELETE FROM karyawan WHERE id = '$id_hapus'";
    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>alert('Data Karyawan Berhasil Dihapus!'); window.location='dashboard.php';</script>";
    }
}

// Ambil Data Karyawan dari Database
$result = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - Enterprise Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .main-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
        }
        .table th {
            color: #64748b;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .btn-action {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            padding: 6px 12px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        .btn-action:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }
        .btn-delete {
            background: #ffffff;
            border: 1.5px solid #fecaca;
            color: #dc2626;
            font-size: 13px;
            font-weight: 500;
            border-radius: 8px;
            padding: 6px 12px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }
        .btn-delete:hover {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }
        .btn-tambah {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
        }
        .btn-tambah:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: white;
        }
        .form-control {
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
        }

        /* Styling Responsif */
        @media (max-width: 576px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }
            .btn-tambah {
                width: 100%;
            }
            .action-group {
                flex-direction: column;
                gap: 6px;
            }
            .btn-action, .btn-delete {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-custom py-3 mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1 fw-bold text-dark fs-5">Enterprise Portal</span>
        <div class="d-flex align-items-center gap-3">
            <span class="small text-secondary d-none d-sm-inline">Halo, Admin</span>
            <a href="index.php" class="btn btn-outline-danger btn-sm rounded-2">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="main-card p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4 header-container">
            <div>
                <h5 class="fw-bold mb-1">Daftar Karyawan & Gaji</h5>
                <p class="text-muted small mb-0">Kelola data karyawan dan buat slip gaji otomatis.</p>
            </div>
            <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Karyawan</button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): 
                            $words = explode(" ", $row['nama']);
                            $inisial = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar"><?php echo $inisial; ?></div>
                                    <div>
                                        <div class="fw-semibold text-dark"><?php echo htmlspecialchars($row['nama']); ?></div>
                                        <div class="text-muted small"><?php echo htmlspecialchars($row['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-medium text-secondary"><?php echo htmlspecialchars($row['nik']); ?></td>
                            <td class="fw-medium text-dark"><?php echo htmlspecialchars($row['jabatan']); ?></td>
                            <td class="fw-semibold text-dark">Rp <?php echo number_format($row['gaji_pokok'], 0, ',', '.'); ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2 action-group">
                                    <a href="slip_gaji.php?id=<?php echo $row['id']; ?>" class="btn-action">
                                        📄 Slip Gaji
                                    </a>
                                    <a href="dashboard.php?hapus=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        🗑️ Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Data karyawan masih kosong. Klik tombol <strong>+ Tambah Karyawan</strong> untuk memasukkan data baru.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal Form Tambah Karyawan -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dashboard.php" method="POST">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad Pratama" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">NIK</label>
                            <input type="text" name="nik" class="form-control" placeholder="320501230045" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@perusahaan.co.id" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Junior Web Programmer" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Gaji Pokok (Rp)</label>
                            <input type="number" name="gaji_pokok" class="form-control" placeholder="4500000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_karyawan" class="btn btn-tambah">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>