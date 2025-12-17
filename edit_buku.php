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
      <li><i class="fa fa-edit"></i> Edit Data Buku</li>
    </ol>
  </div>
</div>

<?php
include 'koneksi.php';

if (!isset($_GET['id_buku'])) {
    echo "<script>alert('ID Buku tidak ditemukan');window.location='index.php';</script>";
    exit;
}

$id_buku = (int) $_GET['id_buku'];

// ================= UPDATE DATA =================
if (isset($_POST['edit'])) {

    $judul_buku = trim($_POST['judul_buku']);
    $pengarang  = trim($_POST['pengarang']);
    $kategori   = trim($_POST['kategori']);

    if ($judul_buku == "" || $pengarang == "" || $kategori == "") {
        echo "<script>alert('Tolong lengkapi semua data!');</script>";
    } else {

        $stmt = $conn->prepare("
            UPDATE buku 
            SET judul_buku = ?, pengarang = ?, kategori = ?
            WHERE id_buku = ?
        ");
        $stmt->bind_param("sssi", $judul_buku, $pengarang, $kategori, $id_buku);

        if ($stmt->execute()) {
            echo "<script>
                alert('Data buku berhasil diupdate!');
                window.location.href='index.php';
            </script>";
        } else {
            echo "<script>alert('Gagal update data');</script>";
        }
    }
}
?>

<form method="POST">

<?php
$stmt = $conn->prepare("SELECT * FROM buku WHERE id_buku = ?");
$stmt->bind_param("i", $id_buku);
$stmt->execute();
$data = $stmt->get_result();

if ($data->num_rows > 0):
$row = $data->fetch_assoc();
?>

<div class="form-group row">
  <label class="col-sm-2 col-form-label">Judul Buku</label>
  <div class="col-sm-5">
    <input type="text" class="form-control" name="judul_buku"
           value="<?= htmlspecialchars($row['judul_buku']) ?>">
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-2 col-form-label">Pengarang</label>
  <div class="col-sm-5">
    <input type="text" class="form-control" name="pengarang"
           value="<?= htmlspecialchars($row['pengarang']) ?>">
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-2 col-form-label">Kategori</label>
  <div class="col-sm-5">
    <select class="form-control" name="kategori">
      <?php
      $kategoriList = ['Pendidikan','Teknologi','Sains','Sosial','Novel','Lainnya'];
      foreach ($kategoriList as $kat):
      ?>
        <option value="<?= $kat ?>" <?= ($row['kategori']==$kat)?'selected':'' ?>>
          <?= $kat ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="mt-3">
  <a href="index.php" class="btn btn-outline-danger mr-2">
    <i class="fa fa-close"></i> Cancel
  </a>
  <button type="submit" name="edit" class="btn btn-outline-primary">
    <i class="fa fa-edit"></i> Update
  </button>
</div>

<?php endif; ?>

</form>

</section>
</section>
</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
