// ================= OVERRIDING METODE ABSTRAK =================

    /**
     * Mengoverride fungsi hitungTotalBiaya() dari kelas induk.
     * Logika: Total Biaya = biayaPendaftaranDasar (Tarif standar murni).
     * * @return double
     */
    public function hitungTotalBiaya() {
        // Mengembalikan nilai dasar secara murni tanpa tambahan biaya seleksi/lab
        return $this->biayaPendaftaranDasar;
    } 