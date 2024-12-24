<?php
$host = 'localhost'; // Alamat server database
$username = 'root';  // Username database
$password = '';      // Password database
$dbname = 'infoUKMtelkom';     // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
