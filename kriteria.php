<!doctype html>
<html lang="en">
<?php include 'components/head.php'; ?>
<body>

<div class="wrapper d-flex align-items-stretch">
<?php include 'components/sidebar.php'; ?>

<div id="content" class="p-4 p-md-5">
<?php include 'components/navbar.php'; ?>

<section id="main-content">
<section class="wrapper">

<h4><i class="fa fa-sliders"></i> Input Bobot Kriteria (SAW)</h4>
<hr>

<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $bobot = [
        1 => $_POST['bobot_jumlah'],
        2 => $_POST['bobot_kedisiplinan'],
        3 => $_POST['bobot_lama'],
        4 => $_POST['bobot_frekuensi']
    ];

    $total = array_sum($bobot);

    if ($total != 1) {
        echo "<script>alert('Total bobot harus = 1');</script>";
    } else {

        foreach ($bobot as $id => $nilai) {
            $stmt = $conn->prepare(
                "UPDATE kriteria SET bobot=? WHERE id_kriteria=?"
            );
            $stmt->bind_param("di", $nilai, $id);
            $stmt->execute();
        }

        echo "<script>alert('Bobot kriteria berhasil disimpan');</script>";
    }
}
?>

<form method="post">

<table class="table table-bordered">
<tr>
    <th>Kriteria</th>
    <th>Tipe</th>
    <th>Bobot</th>
</tr>

<tr>
    <td>Jumlah Pinjaman</td>
    <td>Benefit</td>
    <td><input type="number" step="0.01" name="bobot_jumlah" class="form-control" required></td>
</tr>

<tr>
    <td>Kedisiplinan</td>
    <td>Benefit</td>
    <td><input type="number" step="0.01" name="bobot_kedisiplinan" class="form-control" required></td>
</tr>

<tr>
    <td>Lama Pinjam</td>
    <td>Cost</td>
    <td><input type="number" step="0.01" name="bobot_lama" class="form-control" required></td>
</tr>

<tr>
    <td>Frekuensi Pinjam</td>
    <td>Benefit</td>
    <td><input type="number" step="0.01" name="bobot_frekuensi" class="form-control" required></td>
</tr>
</table>

<button class="btn btn-primary" name="simpan">
<i class="fa fa-save"></i> Simpan Bobot
</button>

</form>

</section>
</section>
</div>
</div>

</body>
</html>
