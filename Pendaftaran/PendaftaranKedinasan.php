<?php

// Pastikan file abstract class sudah di-include sebelum kelas ini digunakan
// require_once 'Pendaftaran.php';

class PendaftaranKedinasan extends Pendaftaran {
    // Properti tambahan spesifik untuk Jalur Kedinasan
    private $skIkatanDinas;
    private $instansiSponsor;

    // Constructor Kelas Anak
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jalur_pendaftaran, $skIkatanDinas, $instansiSponsor) {
        // Memanggil constructor dari abstract class induk (Pendaftaran)
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jalur_pendaftaran);
        
        // Inisialisasi properti spesifik kelas anak
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    // ================= IMPLEMENTASI METODE ABSTRAK =================

    /**
     * Mengimplementasikan logika perhitungan biaya untuk jalur kedinasan.
     * Misal: Total biaya ditambahkan biaya Diklat/Tes Fisik sebesar 750.000.
     */
    public function hitungTotalBiaya() {
        $biayaDiklatDanFisik = 750000;
        return $this->biayaPendaftaranDasar + $biayaDiklatDanFisik;
    }

    /**
     * Mengimplementasikan logika untuk menampilkan informasi spesifik jalur kedinasan.
     */
    public function tampilkanInfoJalur() {
        echo "<h3>Informasi Jalur Pendaftaran: Kedinasan</h3>";
        echo "ID Pendaftaran: " . $this->id_pendaftaran . "<br>";
        echo "Nama Calon: " . $this->nama_calon . "<br>";
        echo "No. SK Ikatan Dinas: " . $this->skIkatanDinas . "<br>";
        echo "Instansi Sponsor: " . $this->instansiSponsor . "<br>";
        echo "Total Biaya (Dasar + Diklat): Rp " . number_format($this->hitungTotalBiaya(), 2, ',', '.') . "<br>";
    }

    // ================= METODE QUERY SPESIFIK =================

    /**
     * Mengambil seluruh data mahasiswa dari database yang mendaftar melalui jalur 'Kedinasan'.
     * @param PDO $db Objek koneksi database PDO
     * @return array Sekumpulan objek PendaftaranKedinasan
     */
    public static function getDaftarKedinasan($db) {
        $daftarKedinasan = [];
        
        try {
            // Query SQL spesifik untuk memfilter data yang hanya relevan dengan jalur 'Kedinasan'
            $query = "SELECT id_pendaftaran, nama_calon, asal_sekolah, nilai_ujian, 
                             biaya_pendaftaran_dasar, jalur_pendaftaran, sk_ikatan_dinas, instansi_sponsor 
                      FROM tabel_pendaftaran 
                      WHERE jalur_pendaftaran = 'Kedinasan'";
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            
            // Memetakan hasil query menjadi array of object (PendaftaranKedinasan)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $daftarKedinasan[] = new self(
                    $row['id_pendaftaran'],
                    $row['nama_calon'],
                    $row['asal_sekolah'],
                    $row['nilai_ujian'],
                    $row['biaya_pendaftaran_dasar'],
                    $row['jalur_pendaftaran'],
                    $row['sk_ikatan_dinas'],   // dipetakan ke $skIkatanDinas
                    $row['instansi_sponsor']   // dipetakan ke $instansiSponsor
                );
            }
        } catch (PDOException $e) {
            echo "Gagal mengambil data jalur kedinasan: " . $e->getMessage();
        }
        
        return $daftarKedinasan;
    }

    // ================= GETTER & SETTER SPESIFIK =================
    public function getSkIkatanDinas() {
        return $this->skIkatanDinas;
    }

    public function setSkIkatanDinas($skIkatanDinas) {
        $this->skIkatanDinas = $skIkatanDinas;
    }

    public function getInstansiSponsor() {
        return $this->instansiSponsor;
    }

    public function setInstansiSponsor($instansiSponsor) {
        $this->instansiSponsor = $instansiSponsor;
    }
}