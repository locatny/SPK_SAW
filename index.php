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

<div class="row">
  <div class="col-lg-12">
    <ol class="breadcrumb">
      <li><i class="fa fa-book"></i> Data Buku</li>
    </ol>
  </div>
</div>

<?php
include 'koneksi.php';

/* ================= INSERT DATA ================= */
if (isset($_POST['submit'])) {

    $judul_buku = trim($_POST['judul_buku']);
    $pengarang  = trim($_POST['pengarang']);
    $kategori   = trim($_POST['kategori']);

    if ($judul_buku == "" || $pengarang == "" || $kategori == "") {
        echo "<script>alert('Lengkapi semua data!');</script>";
    } else {

        $stmt = $conn->prepare("SELECT id_buku FROM buku WHERE judul_buku = ?");
        $stmt->bind_param("s", $judul_buku);
        $stmt->execute();
        $cek = $stmt->get_result();

        if ($cek->num_rows > 0) {
            echo "<script>alert('Buku sudah terdaftar!');</script>";
        } else {

            $stmt = $conn->prepare("
                INSERT INTO buku (judul_buku, pengarang, kategori)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("sss", $judul_buku, $pengarang, $kategori);
            $stmt->execute();

            echo "<script>alert('Data buku berhasil ditambahkan');</script>";
        }
    }
}
?>

<!-- ================= FORM INPUT ================= -->
<form method="POST">
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Judul Buku</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="judul_buku" required>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Pengarang</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="pengarang" required>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Kategori</label>
    <div class="col-sm-5">
      <select class="form-control" name="kategori" required>
        <option value="">-- Pilih --</option>
        <option>Pendidikan</option>
        <option>Teknologi</option>
        <option>Novel</option>
        <option>Sejarah</option>
        <option>Lainnya</option>
      </select>
    </div>
  </div>

  <div class="mb-4">
    <button type="submit" name="submit" class="btn btn-outline-primary">
      <i class="fa fa-save"></i> Simpan
    </button>
  </div>
</form>

<!-- ================= TABLE ================= -->
<table class="table table-bordered">
<thead>
<tr>
  <th>No</th>
  <th>Judul Buku</th>
  <th>Pengarang</th>
  <th>Kategori</th>
  <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;
$data = $conn->query("SELECT * FROM buku ORDER BY judul_buku ASC");
while ($row = $data->fetch_assoc()):
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($row['judul_buku']) ?></td>
  <td><?= htmlspecialchars($row['pengarang']) ?></td>
  <td><?= htmlspecialchars($row['kategori']) ?></td>
  <td>
    <a class="btn btn-success"
       href="edit_buku.php?id_buku=<?= $row['id_buku'] ?>">
       <i class="fa fa-edit"></i>
    </a>
    <a class="btn btn-danger"
       href="hapus_buku.php?id_buku=<?= $row['id_buku'] ?>"
       onclick="return confirm('Yakin hapus buku ini?')">
       <i class="fa fa-trash"></i>
    </a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</section>
</section>

</div>
</div>

</body>
</html>
