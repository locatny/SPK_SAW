<?php
include 'koneksi.php';

if (!isset($_GET['id_anggota'])) {
    echo "<script>alert('ID anggota tidak ditemukan');window.location='penilaian.php';</script>";
    exit;
}

$id_anggota = (int) $_GET['id_anggota'];

$stmt = $conn->prepare("DELETE FROM nilai_kriteria WHERE id_anggota = ?");
$stmt->bind_param("i", $id_anggota);

if ($stmt->execute()) {
    echo "<script>
        alert('Semua penilaian anggota berhasil dihapus!');
        window.location.href='penilaian.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus penilaian!');
        window.location.href='penilaian.php';
    </script>";
}
?>
