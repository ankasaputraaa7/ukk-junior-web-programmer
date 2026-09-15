<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id = '$id'");
$karyawan = mysqli_fetch_assoc($query);

$nama       = $karyawan['nama'] ?? 'Anka Iccong Saputra';
$nik        = $karyawan['nik'] ?? '320501230045';
$email      = $karyawan['email'] ?? 'karyawan@perusahaan.co.id';
$jabatan    = $karyawan['jabatan'] ?? 'Junior Web Programmer';
$gajiPokok = $karyawan['gaji_pokok'] ?? 4500000;
$periode    = $karyawan['periode'] ?? '25 November 2026 - 25 Desember 2026';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - <?php echo htmlspecialchars($nama); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; }
        .navbar-custom { background: #ffffff; border-bottom: 1px solid #e2e8f0; }
        .slip-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
        .header-bg { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; border-radius: 12px; padding: 20px; }
        .section-title { background: #f1f5f9; color: #334155; padding: 8px 14px; font-weight: 600; font-size: 13px; border-radius: 8px; letter-spacing: 0.5px; }
        .form-control { border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px; }
        .captcha-box { font-weight: 700; background: #ffffff; color: #1e293b; font-size: 20px; padding: 8px 20px; border-radius: 8px; border: 1.5px solid #cbd5e1; user-select: none; display: inline-block; }
        .btn-submit-main { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; font-weight: 600; border: none; border-radius: 10px; padding: 10px 24px; transition: all 0.2s; }
        .btn-submit-main:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-custom py-3 mb-4">
    <div class="container">
        <a href="dashboard.php" class="text-decoration-none fw-bold text-dark fs-5">← Enterprise Portal</a>
        <span class="small text-secondary">Proses Slip Gaji Karyawan</span>
    </div>
</nav>

<div class="container mb-5">
    <div class="slip-card p-4" id="slipContent">
        
        <div class="header-bg text-center mb-4">
            <h4 class="fw-bold mb-1">SLIP GAJI KARYAWAN</h4>
            <small class="opacity-75 fw-medium">PERIODE: <?php echo htmlspecialchars($periode); ?></small>
        </div>

        <form id="gajiForm" action="dashboard.php" method="POST" onsubmit="return handleFormSubmit(event)">
            <input type="hidden" name="update_gaji" value="1">
            <input type="hidden" name="id_karyawan" value="<?php echo $id; ?>">
            <input type="hidden" id="emailKaryawan" value="<?php echo htmlspecialchars($email); ?>">

            <!-- Data Diri Karyawan -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">NAMA KARYAWAN</label>
                    <input type="text" class="form-control fw-semibold" id="nama" value="<?php echo htmlspecialchars($nama); ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">NIK</label>
                    <input type="text" class="form-control fw-semibold" id="nik" value="<?php echo htmlspecialchars($nik); ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">JABATAN</label>
                    <input type="text" class="form-control fw-semibold" id="jabatan" value="<?php echo htmlspecialchars($jabatan); ?>" readonly>
                </div>
            </div>

            <!-- Rincian Gaji -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="section-title mb-3">PENGHASILAN</div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Gaji Pokok (Rp)</label>
                        <input type="number" name="gaji_pokok" class="form-control" id="gajiPokok" value="<?php echo $gajiPokok; ?>" oninput="hitungGaji()" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Lembur (Rp)</label>
                        <input type="number" class="form-control" id="lembur" value="500000" oninput="hitungGaji()">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Total Penghasilan</label>
                        <input type="text" class="form-control fw-bold bg-light" id="totalPenghasilan" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="section-title mb-3">POTONGAN</div>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Pinjaman Karyawan (Rp)</label>
                        <input type="number" class="form-control" id="pinjaman" value="200000" oninput="hitungGaji()">
                    </div>
                    <div class="mb-3" style="margin-top: 86px;">
                        <label class="form-label small fw-semibold text-dark">Total Potongan</label>
                        <input type="text" class="form-control fw-bold bg-light" id="totalPotongan" readonly>
                    </div>
                </div>
            </div>

            <!-- Gaji Bersih -->
            <div class="mb-4 p-3 rounded-3" style="background: #f0fdf4; border: 1.5px solid #bbf7d0;">
                <label class="form-label small fw-bold text-success d-block mb-1">GAJI BERSIH (PENERIMAAN AKHIR)</label>
                <input type="text" class="form-control border-0 bg-transparent fw-bold fs-3 text-success p-0" id="gajiBersih" readonly>
            </div>

            <!-- CAPTCHA Perkalian Matematika -->
            <div class="p-4 bg-light rounded-4 mb-4 border" id="captchaSection">
                <label class="form-label small fw-bold text-dark mb-2">Verifikasi Keamanan (Soal Perkalian Matematika)</label>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span id="captchaSoal" class="captcha-box"></span>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-2" onclick="generateCaptchaPerkalian()">🔄 Acak Soal</button>
                </div>
                <input type="number" id="captchaInput" class="form-control" placeholder="Berapa hasil perkalian di atas?" required>
            </div>

            <!-- Tombol Submit Utama -->
            <div class="d-flex gap-2 justify-content-end" id="actionButtons">
                <a href="dashboard.php" class="btn btn-outline-secondary rounded-3">Batal</a>
                <button type="submit" class="btn btn-submit-main">💾 Submit & Simpan ke Database</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Pop-up Opsi Share -->
<div class="modal fade" id="modalShareOptions" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 text-center p-3">
            <div class="modal-body">
                <div class="display-4 text-success mb-2">✅</div>
                <h4 class="fw-bold text-dark mb-2">Submit Berhasil!</h4>
                <p class="text-muted small mb-4">Data slip gaji telah disiapkan dan siap dibagikan atau diunduh.</p>
                
                <div class="d-grid gap-2 mb-3">
                    <button class="btn btn-primary fw-semibold py-2" onclick="downloadPDF()">📄 Cetak / Download PDF</button>
                    <a id="btnWA" href="#" target="_blank" class="btn btn-success fw-semibold py-2">💬 Kirim ke WhatsApp</a>
                    <a id="btnEmail" href="#" target="_blank" class="btn btn-danger fw-semibold py-2">✉️ Kirim via Gmail Web</a>
                </div>

                <button type="button" class="btn btn-light w-100 text-secondary" onclick="selesaiDanKeDashboard()">Selesai & Kembali ke Dashboard</button>
            </div>
        </div>
    </div>
</div>

<script>
    let angka1 = 0, angka2 = 0, hasilPerkalian = 0;

    function generateCaptchaPerkalian() {
        angka1 = Math.floor(Math.random() * 9) + 2;
        angka2 = Math.floor(Math.random() * 9) + 2;
        hasilPerkalian = angka1 * angka2;
        document.getElementById("captchaSoal").innerText = `${angka1} × ${angka2} = ?`;
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(angka);
    }

    function hitungGaji() {
        const gajiPokok = parseFloat(document.getElementById('gajiPokok').value) || 0;
        const lembur = parseFloat(document.getElementById('lembur').value) || 0;
        const pinjaman = parseFloat(document.getElementById('pinjaman').value) || 0;

        const totalPenghasilan = gajiPokok + lembur;
        const totalPotongan = pinjaman;
        const gajiBersih = totalPenghasilan - totalPotongan;

        document.getElementById('totalPenghasilan').value = formatRupiah(totalPenghasilan);
        document.getElementById('totalPotongan').value = formatRupiah(totalPotongan);
        document.getElementById('gajiBersih').value = formatRupiah(gajiBersih);
    }

    function verifikasiCaptcha() {
        const input = parseInt(document.getElementById("captchaInput").value);
        if (isNaN(input) || input !== hasilPerkalian) {
            alert(`Jawaban CAPTCHA Salah! ${angka1} x ${angka2} bukan ${document.getElementById("captchaInput").value}. Silakan coba lagi.`);
            generateCaptchaPerkalian();
            document.getElementById("captchaInput").value = "";
            return false;
        }
        return true;
    }

    function handleFormSubmit(e) {
        if (!verifikasiCaptcha()) {
            e.preventDefault();
            return false;
        }

        const nama = document.getElementById('nama').value;
        const nik = document.getElementById('nik').value;
        const email = document.getElementById('emailKaryawan').value;
        const gajiBersih = document.getElementById('gajiBersih').value;

        // Siapkan Link WA & Email
        const pesanWA = `Halo ${nama} (NIK: ${nik}), Slip Gaji Anda periode ini telah diterbitkan dengan Gaji Bersih sebesar ${gajiBersih}.`;
        document.getElementById('btnWA').href = `https://api.whatsapp.com/send?text=${encodeURIComponent(pesanWA)}`;

        const subjectEmail = `Slip Gaji Karyawan - ${nama}`;
        const bodyEmail = `Yth. ${nama},\n\nBerikut adalah rincian slip gaji Anda:\nNIK: ${nik}\nGaji Bersih: ${gajiBersih}\n\nTerima kasih.`;
        document.getElementById('btnEmail').href = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(email)}&su=${encodeURIComponent(subjectEmail)}&body=${encodeURIComponent(bodyEmail)}`;

        // Tampilkan Modal Share
        const modalShare = new bootstrap.Modal(document.getElementById('modalShareOptions'));
        modalShare.show();
        
        e.preventDefault();
        return false;
    }

    function downloadPDF() {
        const element = document.getElementById('slipContent');
        const buttons = document.getElementById('actionButtons');
        const captchaSec = document.getElementById('captchaSection');
        
        // SEMBUNYIKAN TOTAL ELEMEN TOMBOL & CAPTCHA SEBELUM RENDER PDF
        buttons.classList.add('d-none');
        captchaSec.classList.add('d-none');

        const opt = {
          margin:       [0.3, 0.3, 0.3, 0.3],
          filename:     `Slip_Gaji_${document.getElementById('nama').value}.pdf`,
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2, scrollY: 0 },
          jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // RENDER DAN UNDUH PDF
        html2pdf().set(opt).from(element).save().then(() => {
            // BERIKAN DELAY SEDIKIT SUPAYA FILE PDF DIJAMIN BERSIH DARI TOMBOL
            setTimeout(() => {
                buttons.classList.remove('d-none');
                captchaSec.classList.remove('d-none');
            }, 500);
        });
    }

    function selesaiDanKeDashboard() {
        document.getElementById('gajiForm').submit();
    }

    window.onload = function() {
        hitungGaji();
        generateCaptchaPerkalian();
    };
</script>

</body>
</html>