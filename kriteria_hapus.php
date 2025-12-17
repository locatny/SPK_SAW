<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID kriteria tidak ditemukan');window.location='kriteria.php';</script>";
    exit;
}

$id = (int) $_GET['id'];

// gunakan prepared statement
$stmt = $conn->prepare("DELETE FROM kriteria WHERE id_kriteria = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo "<script>
            alert('Bobot kriteria berhasil dihapus!');
            window.location.href='kriteria.php';
        </script>";
    } else {
        echo "<script>
            alert('Data kriteria tidak ditemukan!');
            window.location.href='kriteria.php';
        </script>";
    }

} else {
    echo "<script>
        alert('Gagal menghapus data kriteria!');
        window.location.href='kriteria.php';
    </script>";
}
?>
