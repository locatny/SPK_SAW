<?php include 'components/head.php'; ?>
<body>

<div class="wrapper d-flex align-items-stretch">
<?php include 'components/sidebar.php'; ?>

<div id="content" class="p-4 p-md-5">
<?php include 'components/navbar.php'; ?>

<section id="main-content">
<section class="wrapper">

<h3><i class="fa fa-calculator"></i> Perhitungan SAW</h3>
<hr>

<?php
include 'koneksi.php';

/* ===============================
   AMBIL KRITERIA & BOBOT
================================ */
$kriteria = [];
$q = $conn->query("SELECT * FROM kriteria");
while ($r = $q->fetch_assoc()) {
    $kriteria[$r['id_kriteria']] = $r;
}

/* ===============================
   AMBIL NILAI ALTERNATIF (X)
================================ */
$data = $conn->query("
    SELECT a.id_anggota, a.nama_anggota,
           nk.id_kriteria, nk.nilai
    FROM nilai_kriteria nk
    JOIN anggota a ON nk.id_anggota = a.id_anggota
    ORDER BY a.nama_anggota
");

$X = [];
while ($row = $data->fetch_assoc()) {
    $X[$row['id_anggota']]['nama'] = $row['nama_anggota'];
    $X[$row['id_anggota']]['nilai'][$row['id_kriteria']] = $row['nilai'];
}

/* ===============================
   HITUNG MAX & MIN
================================ */
$max = [];
$min = [];

foreach ($kriteria as $id_kriteria => $k) {
    $values = [];

    foreach ($X as $alt) {
        if (isset($alt['nilai'][$id_kriteria])) {
            $values[] = $alt['nilai'][$id_kriteria];
        }
    }

    // Cegah array kosong
    $max[$id_kriteria] = !empty($values) ? max($values) : 0;
    $min[$id_kriteria] = !empty($values) ? min($values) : 0;
}

/* ===============================
   NORMALISASI (R)
================================ */
$R = [];
foreach ($X as $id => $alt) {
    foreach ($alt['nilai'] as $id_kriteria => $nilai) {
        if ($kriteria[$id_kriteria]['tipe'] == 'benefit') {
            $R[$id][$id_kriteria] = $max[$id_kriteria] != 0
                ? $nilai / $max[$id_kriteria]
                : 0;
} else {
    $R[$id][$id_kriteria] = $nilai != 0
        ? $min[$id_kriteria] / $nilai
        : 0;
}
    }
}

/* ===============================
   HITUNG NILAI PREFERENSI
================================ */
$hasil = [];
foreach ($R as $id => $nilaiR) {
    $total = 0;
    foreach ($nilaiR as $id_kriteria => $r) {
        $total += $r * $kriteria[$id_kriteria]['bobot'];
    }
    $hasil[] = [
        'id' => $id,
        'nama' => $X[$id]['nama'],
        'nilai' => round($total, 4)
    ];
}

/* ===============================
   SORT RANKING
================================ */
usort($hasil, fn($a,$b) => $b['nilai'] <=> $a['nilai']);
?>

<!-- ===============================
     HASIL AKHIR
================================ -->
<h4>Hasil Perankingan SAW</h4>
<table class="table table-bordered">
<thead>
<tr>
    <th>Rank</th>
    <th>Nama Anggota</th>
    <th>Nilai Preferensi</th>
</tr>
</thead>
<tbody>
<?php $rank=1; foreach ($hasil as $row): ?>
<tr>
    <td><?= $rank++ ?></td>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['nilai'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</section>
</section>
</div>
</div>

</body>
</html>
