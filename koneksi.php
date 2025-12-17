<?php
$host = "localhost";
$user = "root";          // default XAMPP
$pass = "";              // default XAMPP
$db   = "saw_peminjaman_buku"; // NAMA DATABASE BARU

$conn = new mysqli($host, $user, $pass, $db);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
