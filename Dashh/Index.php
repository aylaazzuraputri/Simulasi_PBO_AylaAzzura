<?php
// ==========================================
// 1. KONEKSI DATABASE & INITIALIZATION
// ==========================================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_simulasi"; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli($host, $user, $pass);

// Buat database otomatis jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS $db");
$conn->select_db($db);

// Menyelaraskan struktur tabel pendaftar dengan ENUM jalur
$conn->query("CREATE TABLE IF NOT EXISTS pendaftar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jalur ENUM('Reguler', 'Prestasi', 'Kedinasan') NOT NULL,
    atribut_spesifik VARCHAR(255) NOT NULL,
    biaya_dasar DECIMAL(10,2) NOT NULL
)");

// Sinkronisasi isi 20 data dummy lengkap ke dalam database pendaftar
$cekData = $conn->query("SELECT id FROM pendaftar LIMIT 1");
if ($cekData->num_rows == 0) {
    $conn->query("INSERT INTO pendaftar (nama, jalur, atribut_spesifik, biaya_dasar) VALUES
    ('Ayla Azzura', 'Reguler', '95.5', 1000000),
    ('Budi Santoso', 'Reguler', '85.5', 1000000),
    ('Siti Nurbaya', 'Reguler', '92.0', 1000000),
    ('Ahmad Fauzi', 'Reguler', '88.5', 1000000),
    ('Rian Hidayat', 'Reguler', '84.0', 1000000),
    ('Lestari Putri', 'Reguler', '89.5', 1000000),
    ('Diki Wahyudi', 'Reguler', '79.5', 1000000),
    ('Hendra Wijaya', 'Prestasi', 'Olimpiade Matematika Nasional', 1200000),
    ('Rizky Billar', 'Prestasi', 'Juara 2 Pencak Silat', 1200000),
    ('Dewi Lestari', 'Prestasi', 'Juara 1 FLS2N Nasional', 1200000),
    ('Fajar Nugraha', 'Prestasi', 'Juara 3 Ketangkasan Robotik', 1200000),
    ('Siska Amelia', 'Prestasi', 'Juara 1 Debat Bahasa Inggris', 1200000),
    ('Andi Wijaya', 'Prestasi', 'Pemenang Medali Perunggu OSN', 1200000),
    ('Oki Setiawan', 'Kedinasan', 'SK-DIK-2026-001 / Kemendagri', 1500000),
    ('Doni Setiawan', 'Kedinasan', 'SKCK Valid / Terverifikasi', 1500000),
    ('Putri Utami', 'Kedinasan', 'Rekomendasi Dinas Pendidikan', 1500000),
    ('Eko Prasetyo', 'Kedinasan', 'Taruna Ikatan Dinas Akpol', 1500000),
    ('Amalia Rizki', 'Kedinasan', 'Verifikasi Badan Sandi Negara', 1500000),
    ('Gilang Dirga', 'Kedinasan', 'SK-DINAS-2026-009 / Kemenhub', 1500000),
    ('Taufik Hidayat', 'Kedinasan', 'Rekomendasi Pemprov Jateng', 1500000)");
}

// ==========================================
// 2. STRUKTUR CLASS OOP & POLIMORFISME
// ==========================================
abstract class Mahasiswa {
    public $id, $nama, $biayaDasar;
    
    public function __construct($id, $nama, $biayaDasar) {
        $this->id = $id;
        $this->nama = $nama;
        $this->biayaDasar = $biayaDasar;
    }
    
    abstract public function tampilkanInfoJalur();
    abstract public function hitungTotalBiaya();
}

class JalurReguler extends Mahasiswa {
    private $nilaiUjian;
    
    public function __construct($id, $nama, $nilai, $biaya) {
        parent::__construct($id, $nama, $biaya);
        $this->nilaiUjian = $nilai;
    }
    
    public function tampilkanInfoJalur() { return "📝 Nilai Ujian: " . $this->nilaiUjian; }
    public function hitungTotalBiaya() { return $this->biayaDasar + 250000; } 
}

class JalurPrestasi extends Mahasiswa {
    private $namaPrestasi;
    
    public function __construct($id, $nama, $prestasi, $biaya) {
        parent::__construct($id, $nama, $biaya);
        $this->namaPrestasi = $prestasi;
    }
    
    public function tampilkanInfoJalur() { return "🏆 Prestasi: " . $this->namaPrestasi; }
    public function hitungTotalBiaya() { return $this->biayaDasar * 0.5; } 
}

class JalurKedinasan extends Mahasiswa {
    private $statusSkck;
    
    public function __construct($id, $nama, $skck, $biaya) {
        parent::__construct($id, $nama, $biaya);
        $this->statusSkck = $skck;
    }
    
    public function tampilkanInfoJalur() { return "🛡️ " . $this->statusSkck; }
    public function hitungTotalBiaya() { return $this->biayaDasar + 750000; } 
}

// ==========================================
// 3. OPTIMASI QUERY (SINGLE PASSTHROUGH)
// ==========================================
$result = $conn->query("SELECT * FROM pendaftar");

$mahasiswaReguler   = [];
$mahasiswaPrestasi  = [];
$mahasiswaKedinasan = [];

while ($row = $result->fetch_assoc()) {
    if ($row['jalur'] == 'Reguler') {
        $mahasiswaReguler[] = new JalurReguler($row['id'], $row['nama'], $row['atribut_spesifik'], $row['biaya_dasar']);
    } elseif ($row['jalur'] == 'Prestasi') {
        $mahasiswaPrestasi[] = new JalurPrestasi($row['id'], $row['nama'], $row['atribut_spesifik'], $row['biaya_dasar']);
    } elseif ($row['jalur'] == 'Kedinasan') {
        $mahasiswaKedinasan[] = new JalurKedinasan($row['id'], $row['nama'], $row['atribut_spesifik'], $row['biaya_dasar']);
    }
}

$totalPendaftar = count($mahasiswaReguler) + count($mahasiswaPrestasi) + count($mahasiswaKedinasan);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PMB - OOP Polimorfisme</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased flex flex-col min-h-screen">

    <nav class="bg-slate-900 text-white shadow-md sticky top-0 z-50 h-16 flex items-center">
        <div class="w-full px-6 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🎓</span>
                <span class="font-extrabold text-xl tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-400">
                    PBO_SISTEM_PMB
                </span>
            </div>
            <div class="flex items-center space-x-2 bg-slate-800 px-4 py-1.5 rounded-full border border-slate-700">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-gray-300 text-sm font-medium">Admin Ayla ✨</span>
            </div>
        </div>
    </nav>

    <div class="flex flex-1 flex-col md:flex-row">
        
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 border-t border-slate-800 md:border-t-0 md:border-r flex flex-col sticky top-16 h-auto md:h-[calc(100vh-4rem)] z-40">
            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-4">Navigasi Jalur</p>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#ringkasan" class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-800 text-white font-medium hover:bg-slate-800 transition">
                            <span class="flex items-center gap-3">📊 <span>Ringkasan</span></span>
                            <span class="bg-slate-700 text-slate-300 text-xs px-2.5 py-0.5 rounded-full font-bold"><?= $totalPendaftar ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#reguler" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800/60 hover:text-white transition group">
                            <span class="flex items-center gap-3">📋 <span class="group-hover:translate-x-1 transition-transform">Jalur Reguler</span></span>
                            <span class="bg-blue-950/60 text-blue-400 border border-blue-900/50 text-xs px-2.5 py-0.5 rounded-full font-bold"><?= count($mahasiswaReguler) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#prestasi" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800/60 hover:text-white transition group">
                            <span class="flex items-center gap-3">🌟 <span class="group-hover:translate-x-1 transition-transform">Jalur Prestasi</span></span>
                            <span class="bg-emerald-950/60 text-emerald-400 border border-emerald-900/50 text-xs px-2.5 py-0.5 rounded-full font-bold"><?= count($mahasiswaPrestasi) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#kedinasan" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800/60 hover:text-white transition group">
                            <span class="flex items-center gap-3">🎖️ <span class="group-hover:translate-x-1 transition-transform">Jalur Kedinasan</span></span>
                            <span class="bg-amber-950/60 text-amber-400 border border-amber-900/50 text-xs px-2.5 py-0.5 rounded-full font-bold"><?= count($mahasiswaKedinasan) ?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="mt-auto p-6 hidden md:block border-t border-slate-800/60 bg-slate-950/30 text-[11px] text-slate-500">
                Sistem Database: <span class="text-slate-400 font-mono">db_simulasi</span>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            
            <div id="ringkasan" class="mb-8 pt-2">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Dashboard Pendaftaran Mahasiswa</h1>
                <p class="text-slate-500 mt-1 text-sm">Sistem Manajemen PMB Berbasis Objek dengan Implementasi Polimorfisme Diferensiasi Jalur.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Total Pendaftar</p>
                        <p class="text-2xl font-black text-slate-800 mt-1.5"><?= $totalPendaftar; ?> <span class="text-xs font-normal text-slate-400">Orang</span></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-[11px] text-blue-500 font-bold uppercase tracking-wider">Jalur Reguler</p>
                        <p class="text-2xl font-black text-blue-600 mt-1.5"><?= count($mahasiswaReguler); ?> <span class="text-xs font-normal text-slate-400">Mhs</span></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-[11px] text-emerald-500 font-bold uppercase tracking-wider">Jalur Prestasi</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1.5"><?= count($mahasiswaPrestasi); ?> <span class="text-xs font-normal text-slate-400">Mhs</span></p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-[11px] text-amber-500 font-bold uppercase tracking-wider">Jalur Kedinasan</p>
                        <p class="text-2xl font-black text-amber-600 mt-1.5"><?= count($mahasiswaKedinasan); ?> <span class="text-xs font-normal text-slate-400">Mhs</span></p>
                    </div>
                </div>
            </div>

            <div class="space-y-12">
                
                <div id="reguler" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden scroll-mt-20">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-white font-bold tracking-wide flex items-center gap-2">
                            <span>📋</span> DAFTAR MAHASISWA - JALUR REGULER
                        </h2>
                        <span class="hidden sm:inline bg-blue-800/50 border border-blue-400/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">Class JalurReguler</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 text-xs uppercase font-bold tracking-wider">
                                    <th class="p-4 w-24 text-center">ID</th>
                                    <th class="p-4">Nama Lengkap</th>
                                    <th class="p-4">Atribut Unik (Overriding Method)</th>
                                    <th class="p-4 text-right">Total Biaya Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                                <?php foreach($mahasiswaReguler as $mhs): ?>
                                    <tr class="hover:bg-slate-50/80 transition duration-150">
                                        <td class="p-4 text-center font-mono text-slate-400 font-bold">#0<?= $mhs->id ?></td>
                                        <td class="p-4 font-semibold text-slate-900"><?= htmlspecialchars($mhs->nama) ?></td>
                                        <td class="p-4"><span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-lg border border-blue-100"><?= htmlspecialchars($mhs->tampilkanInfoJalur()) ?></span></td>
                                        <td class="p-4 text-right font-bold text-slate-900 bg-slate-50/30">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="prestasi" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden scroll-mt-20">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-white font-bold tracking-wide flex items-center gap-2">
                            <span>🌟</span> DAFTAR MAHASISWA - JALUR PRESTASI
                        </h2>
                        <span class="hidden sm:inline bg-emerald-800/50 border border-emerald-400/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">Class JalurPrestasi</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 text-xs uppercase font-bold tracking-wider">
                                    <th class="p-4 w-24 text-center">ID</th>
                                    <th class="p-4">Nama Lengkap</th>
                                    <th class="p-4">Atribut Unik (Overriding Method)</th>
                                    <th class="p-4 text-right">Total Biaya Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                                <?php foreach($mahasiswaPrestasi as $mhs): ?>
                                    <tr class="hover:bg-slate-50/80 transition duration-150">
                                        <td class="p-4 text-center font-mono text-slate-400 font-bold">#0<?= $mhs->id ?></td>
                                        <td class="p-4 font-semibold text-slate-900"><?= htmlspecialchars($mhs->nama) ?></td>
                                        <td class="p-4"><span class="bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-lg border border-emerald-100"><?= htmlspecialchars($mhs->tampilkanInfoJalur()) ?></span></td>
                                        <td class="p-4 text-right font-bold text-emerald-600 bg-slate-50/30">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="kedinasan" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden scroll-mt-20">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-white font-bold tracking-wide flex items-center gap-2">
                            <span>🎖️</span> DAFTAR MAHASISWA - JALUR KEDINASAN
                        </h2>
                        <span class="hidden sm:inline bg-amber-700/50 border border-amber-400/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">Class JalurKedinasan</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 text-xs uppercase font-bold tracking-wider">
                                    <th class="p-4 w-24 text-center">ID</th>
                                    <th class="p-4">Nama Lengkap</th>
                                    <th class="p-4">Atribut Unik (Overriding Method)</th>
                                    <th class="p-4 text-right">Total Biaya Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                                <?php foreach($mahasiswaKedinasan as $mhs): ?>
                                    <tr class="hover:bg-slate-50/80 transition duration-150">
                                        <td class="p-4 text-center font-mono text-slate-400 font-bold">#0<?= $mhs->id ?></td>
                                        <td class="p-4 font-semibold text-slate-900"><?= htmlspecialchars($mhs->nama) ?></td>
                                        <td class="p-4"><span class="bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-lg border border-amber-100"><?= htmlspecialchars($mhs->tampilkanInfoJalur()) ?></span></td>
                                        <td class="p-4 text-right font-bold text-slate-900 bg-slate-50/30">Rp <?= number_format($mhs->hitungTotalBiaya(), 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            
            <footer class="mt-16 border-t border-slate-200 py-6 text-center text-xs text-slate-400 font-medium">
                &copy; 2026 PBO-Sistem-PMB. Terintegrasi Otomatis dengan Basis Data.
            </footer>
        </main>
    </div>
</body>
</html>