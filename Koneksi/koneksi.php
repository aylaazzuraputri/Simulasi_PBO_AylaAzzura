<?php
$host     = "localhost";
$username = "root"; // sesuaikan dengan username MySQL Anda
$password = "";     // sesuaikan dengan password MySQL Anda
$database = "db_simulasi_pbo_trpl1a_aylaazzura";

try {
    // Menggunakan PDO (PHP Data Objects) yang mendukung konsep OOP
    $koneksi = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    
    // Set mode error PDO ke Exception
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Koneksi ke database Berhasil!"; 
} catch(PDOException $e) {
    echo "Koneksi ke database Gagal: " . $e->getMessage();
}
?>