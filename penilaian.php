<?php include 'components/head.php'; ?>
<body>

<div class="wrapper d-flex align-items-stretch">
<?php include 'components/sidebar.php'; ?>

<div id="content" class="p-4 p-md-5">
<?php include 'components/navbar.php'; ?>

<section class="wrapper">
<h3><i class="fa fa-list-ol"></i> Input Nilai Kriteria</h3>
<hr>

<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {

    $id_anggota  = (int) $_POST['id_anggota'];
    $id_kriteria = (int) $_POST['id_kriteria'];
    $nilai       = (float) $_POST['nilai'];

    if ($nilai <= 0) {
        echo "<script>alert('Nilai tidak valid');</script>";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO nilai_kriteria (id_anggota, id_kriteria, nilai)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("iid", $id_anggota, $id_kriteria, $nilai);
        $stmt->execute();

        echo "<script>alert('Nilai berhasil disimpan');</script>";
    }
}
?>

<form method="POST">
<div class="form-group">
    <label>Anggota</label>
    <select name="id_anggota" class="form-control" required>
        <?php
        $q = $conn->query("SELECT * FROM anggota");
        while ($a = $q->fetch_assoc()):
        ?>
        <option value="<?= $a['id_anggota'] ?>"><?= $a['nama_anggota'] ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label>Kriteria</label>
    <select name="id_kriteria" class="form-control" required>
        <?php
        $q = $conn->query("SELECT * FROM kriteria");
        while ($k = $q->fetch_assoc()):
        ?>
        <option value="<?= $k['id_kriteria'] ?>"><?= $k['nama_kriteria'] ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div class="form-group">
    <label>Nilai</label>
    <input type="number" step="0.01" name="nilai" class="form-control" required>
</div>

<button class="btn btn-primary" name="submit">
    <i class="fa fa-save"></i> Simpan
</button>
</form>

</section>
</div>
</div>

</body>
</html>
