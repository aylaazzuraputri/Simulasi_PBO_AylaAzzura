// ================= OVERRIDING METODE ABSTRAK =================

    /**
     * Mengoverride fungsi hitungTotalBiaya() dari kelas induk.
     * Logika: Total Biaya = biayaPendaftaranDasar - 50000 (Potongan prestasi).
     * @return double
     */
    public function hitungTotalBiaya() {
        $potonganPrestasi = 50000;
        return $this->biayaPendaftaranDasar - $potonganPrestasi;
    }