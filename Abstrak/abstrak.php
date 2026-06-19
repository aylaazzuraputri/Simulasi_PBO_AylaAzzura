<?php

abstract class Pendaftaran {
    // Atribut Global (Induk) dengan hak akses protected agar bisa diakses kelas anak
    protected $idPendaftaran;
    protected $namaCalon;
    protected $asalSekolah;
    protected $nilaiUjian;
    protected $biayaPendaftaranDasar;
    protected $jalurPendaftaran; // Nilai: Reguler, Prestasi, atau Kedinasan

    // Constructor untuk menginisialisasi atribut global
    public function __construct($idPendaftaran, $namaCalon, $asalSekolah, $nilaiUjian, $biayaPendaftaranDasar, $jalurPendaftaran) {
        $this->idPendaftaran = $idPendaftaran;
        $this->namaCalon = $namaCalon;
        $this->asalSekolah = $asalSekolah;
        $this->nilaiUjian = $nilaiUjian;
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
        $this->jalurPendaftaran = $jalurPendaftaran;
    }

    // Abstract Method: Wajib diimplementasikan oleh kelas anak untuk menghitung total biaya spesifik
    abstract public function hitungTotalBiaya();

    // Abstract Method: Wajib diimplementasikan untuk menampilkan informasi data spesifik pendaftaran
    abstract public function tampilkanData();

    // Getter dan Setter (Encapsulation) untuk atribut global
    public function getIdPendaftaran() {
        return $this->idPendaftaran;
    }

    public function setIdPendaftaran($idPendaftaran) {
        $this->idPendaftaran = $idPendaftaran;
    }

    public function getNamaCalon() {
        return $this->namaCalon;
    }

    public function setNamaCalon($namaCalon) {
        $this->namaCalon = $namaCalon;
    }

    public function getAsalSekolah() {
        return $this->asalSekolah;
    }

    public function setAsalSekolah($asalSekolah) {
        $this->asalSekolah = $asalSekolah;
    }

    public function getNilaiUjian() {
        return $this->nilaiUjian;
    }

    public function setNilaiUjian($nilaiUjian) {
        $this->nilaiUjian = $nilaiUjian;
    }

    public function getBiayaPendaftaranDasar() {
        return $this->biayaPendaftaranDasar;
    }

    public function setBiayaPendaftaranDasar($biayaPendaftaranDasar) {
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
    }

    public function getJalurPendaftaran() {
        return $this->jalurPendaftaran;
    }

    public function setJalurPendaftaran($jalurPendaftaran) {
        $this->jalurPendaftaran = $jalurPendaftaran;
    }
}