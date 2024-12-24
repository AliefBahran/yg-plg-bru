<?php
// File: koneksi.php

// Konfigurasi database
$host = 'localhost'; // Host database
$username = 'root'; // Username MySQL
$password = ''; // Password MySQL (kosongkan jika tidak ada password)
$database = 'ukm_recommendation'; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
} else {
    // echo "Koneksi berhasil"; // Uncomment baris ini untuk debugging
}

?>