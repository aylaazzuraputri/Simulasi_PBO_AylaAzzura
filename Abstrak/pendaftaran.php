<?php

abstract class Pendaftaran {

    protected $id_pendaftaran;
    protected $nama_calon;
    protected $asal_sekolah;
    protected $nilai_ujian;
    protected $biayaPendaftaranDasar;
    
    protected $jalur_pendaftaran; 
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jalur_pendaftaran) {
        $this->id_pendaftaran = $id_pendaftaran;
        $this->nama_calon = $nama_calon;
        $this->asal_sekolah = $asal_sekolah;
        $this->nilai_ujian = $nilai_ujian;
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
        $this->jalur_pendaftaran = $jalur_pendaftaran;
    }

    // Abstract Method yang wajib diimplementasikan oleh kelas anak (Reguler/Prestasi/Kedinasan)
    abstract public function hitungTotalBiaya();
    abstract public function tampilkanData();

    // Getter dan Setter untuk mendukung prinsip Encapsulation jika diakses dari luar class/object
    public function getIdPendaftaran() {
        return $this->id_pendaftaran;
    }

    public function setIdPendaftaran($id_pendaftaran) {
        $this->id_pendaftaran = $id_pendaftaran;
    }

    public function getNamaCalon() {
        return $this->nama_calon;
    }

    public function setNamaCalon($nama_calon) {
        $this->nama_calon = $nama_calon;
    }

    public function getAsalSekolah() {
        return $this->asal_sekolah;
    }

    public function setAsalSekolah($asal_sekolah) {
        $this->asal_sekolah = $asal_sekolah;
    }

    public function getNilaiUjian() {
        return $this->nilai_ujian;
    }

    public function setNilaiUjian($nilai_ujian) {
        $this->nilai_ujian = $nilai_ujian;
    }

    public function getBiayaPendaftaranDasar() {
        return $this->biayaPendaftaranDasar;
    }

    public function setBiayaPendaftaranDasar($biayaPendaftaranDasar) {
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
    }

    public function getJalurPendaftaran() {
        return $this->jalur_pendaftaran;
    }

    public function setJalurPendaftaran($jalur_pendaftaran) {
        $this->jalur_pendaftaran = $jalur_pendaftaran;
    }
}