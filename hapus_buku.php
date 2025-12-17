<?php
include 'koneksi.php';

if (!isset($_GET['id_buku'])) {
    echo "<script>alert('ID buku tidak ditemukan');window.location='index.php';</script>";
    exit;
}

$id_buku = (int) $_GET['id_buku'];

$conn->begin_transaction();

try {

    // Hapus data peminjaman terkait buku
    $stmt1 = $conn->prepare("DELETE FROM peminjaman WHERE id_buku = ?");
    $stmt1->bind_param("i", $id_buku);
    $stmt1->execute();

    // Hapus data buku
    $stmt2 = $conn->prepare("DELETE FROM buku WHERE id_buku = ?");
    $stmt2->bind_param("i", $id_buku);
    $stmt2->execute();

    $conn->commit();

    echo "<script>
        alert('Data buku berhasil dihapus!');
        window.location.href='index.php';
    </script>";

} catch (Exception $e) {

    $conn->rollback();
    echo "<script>alert('Gagal menghapus data buku');</script>";
}
?>
