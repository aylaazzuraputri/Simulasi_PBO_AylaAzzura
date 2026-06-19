<?php

// Pastikan file abstract class sudah di-include sebelum kelas ini digunakan
// require_once 'Pendaftaran.php';

class PendaftaranPrestasi extends Pendaftaran {
    // Properti tambahan spesifik untuk Jalur Prestasi
    private $jenisPrestasi;
    private $tingkatPrestasi;

    // Constructor Kelas Anak
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jalur_pendaftaran, $jenisPrestasi, $tingkatPrestasi) {
        // Memanggil constructor dari abstract class induk (Pendaftaran)
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jalur_pendaftaran);
        
        // Inisialisasi properti spesifik kelas anak
        $this->jenisPrestasi = $jenisPrestasi;
        $this->tingkatPrestasi = $tingkatPrestasi;
    }

    // ================= IMPLEMENTASI METODE ABSTRAK =================

    /**
     * Mengimplementasikan logika perhitungan biaya untuk jalur prestasi.
     * Misal: Mendapatkan potongan harga (diskon) berdasarkan tingkat prestasi.
     */
    public function hitungTotalBiaya() {
        $potongan = 0;
        
        // Logika polimorfisme untuk potongan biaya pendaftaran
        if (strcasecmp($this->tingkatPrestasi, 'Internasional') == 0) {
            $potongan = $this->biayaPendaftaranDasar * 0.50; // Diskon 50%
        } else if (strcasecmp($this->tingkatPrestasi, 'Nasional') == 0) {
            $potongan = $this->biayaPendaftaranDasar * 0.30; // Diskon 30%
        } else {
            $potongan = $this->biayaPendaftaranDasar * 0.15; // Diskon 15% untuk Tingkat Provinsi/Lainnya
        }
        
        return $this->biayaPendaftaranDasar - $potongan;
    }

    /**
     * Mengimplementasikan logika untuk menampilkan informasi spesifik jalur prestasi.
     */
    public function tampilkanInfoJalur() {
        echo "<h3>Informasi Jalur Pendaftaran: Prestasi</h3>";
        echo "ID Pendaftaran: " . $this->id_pendaftaran . "<br>";
        echo "Nama Calon: " . $this->nama_calon . "<br>";
        echo "Jenis Prestasi: " . $this->jenisPrestasi . "<br>";
        echo "Tingkat Prestasi: " . $this->tingkatPrestasi . "<br>";
        echo "Total Biaya (Setelah Potongan Prestasi): Rp " . number_format($this->hitungTotalBiaya(), 2, ',', '.') . "<br>";
    }

    // ================= METODE QUERY SPESIFIK =================

    /**
     * Mengambil seluruh data mahasiswa dari database yang mendaftar melalui jalur 'Prestasi'.
     * @param PDO $db Objek koneksi database PDO
     * @return array Sekumpulan objek PendaftaranPrestasi
     */
    public static function getDaftarPrestasi($db) {
        $daftarPrestasi = [];
        
        try {
            // Query SQL spesifik untuk memfilter data yang hanya relevan dengan jalur 'Prestasi'
            $query = "SELECT id_pendaftaran, nama_calon, asal_sekolah, nilai_ujian, 
                             biaya_pendaftaran_dasar, jalur_pendaftaran, jenis_prestasi, tingkat_prestasi 
                      FROM tabel_pendaftaran 
                      WHERE jalur_pendaftaran = 'Prestasi'";
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            // Memetakan hasil query menjadi array of object (PendaftaranPrestasi)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $daftarPrestasi[] = new self(
                    $row['id_pendaftaran'],
                    $row['nama_calon'],
                    $row['asal_sekolah'],
                    $row['nilai_ujian'],
                    $row['biaya_pendaftaran_dasar'],
                    $row['jalur_pendaftaran'],
                    $row['jenis_prestasi'],   // dipetakan ke $jenisPrestasi
                    $row['tingkat_prestasi']  // dipetakan ke $tingkatPrestasi
                );
            }
        } catch (PDOException $e) {
            echo "Gagal mengambil data jalur prestasi: " . $e->getMessage();
        }
        
        return $daftarPrestasi;
    }

    // ================= GETTER & SETTER SPESIFIK =================
    public function getJenisPrestasi() {
        return $this->jenisPrestasi;
    }

    public function setJenisPrestasi($jenisPrestasi) {
        $this->jenisPrestasi = $jenisPrestasi;
    }

    public function getTingkatPrestasi() {
        return $this->tingkatPrestasi;
    }

    public function setTingkatPrestasi($tingkatPrestasi) {
        $this->tingkatPrestasi = $tingkatPrestasi;
    }
}