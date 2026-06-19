// ================= OVERRIDING METODE ABSTRAK =================

    /**
     * Mengoverride fungsi hitungTotalBiaya() dari kelas induk.
     * Logika: Total Biaya = biayaPendaftaranDasar * 1.25 (Surcharge kemitraan dinas 25%).
     * @return double
     */
    public function hitungTotalBiaya() {
        $multiplierSurcharge = 1.25;
        return $this->biayaPendaftaranDasar * $multiplierSurcharge;
    }