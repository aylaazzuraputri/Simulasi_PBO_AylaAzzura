<?php
// koneksi.php

class KoneksiDB {
    private $host = "localhost";
    private $username = "root";
    private $password = ""; // Kosongkan jika pakai Laragon / XAMPP default
    private $database = "db_simulasi_pbo_trpl1a_aylaazzura";
    private $conn;

    public function hubungkan() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8mb4";
            $opsi = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->conn = new PDO($dsn, $this->username, $this->password, $opsi);
        } catch (PDOException $e) {
            // Membantu tracking jika masalahnya ada pada settingan database lokal
            die("Koneksi gagal! Periksa apakah database sudah dibuat. Pesan: " . $e->getMessage());
        }
        return $this->conn;
    }
}

// Inisialisasi variabel global koneksi
$databaseObj = new KoneksiDB();
$koneksi = $databaseObj->hubungkan();