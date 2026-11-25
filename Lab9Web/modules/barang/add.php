
<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga_beli = (float)($_POST['harga_beli'] ?? 0);
    $harga_jual = (float)($_POST['harga_jual'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);

    $gambar = '';

    if ($nama === '' || $kategori === '' ||
        $harga_beli < 0 || $harga_jual < 0 || $stok < 0) {

        $error = "Data barang tidak boleh kosong atau bernilai negatif.";

    } else {

        if (!empty($_FILES['file_gambar']['name'])) {

            $namaFile = $_FILES['file_gambar']['name'];
            $tmpFile = $_FILES['file_gambar']['tmp_name'];
            $ukuran = $_FILES['file_gambar']['size'];

            $ekstensi = strtolower(
                pathinfo($namaFile, PATHINFO_EXTENSION)
            );

            $daftarEkstensi = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ekstensi, $daftarEkstensi) ||
                $ukuran > 2 * 1024 * 1024 ||
                !is_uploaded_file($tmpFile)) {

                $error = "Gambar harus JPG, PNG, atau WEBP maksimal 2 MB.";

            } else {

                $namaBaru = uniqid('barang_', true) . '.' . $ekstensi;

                if (move_uploaded_file(
                    $tmpFile,
                    __DIR__ . '/../../gambar/' . $namaBaru
                )) {
                    $gambar = 'gambar/' . $namaBaru;
                } else {
                    $error = "Gagal mengunggah gambar.";
                }
            }
        }

        if ($error === '') {

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO data_barang
                (nama, kategori, harga_beli, harga_jual, stok, gambar)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssddis",
                $nama,
                $kategori,
                $harga_beli,
                $harga_jual,
                $stok,
                $gambar
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php?page=barang/list");
                exit;
            } else {
                $error = "Data gagal disimpan.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<section class="content">
    <h2>Tambah Barang</h2>

    <?php if ($error !== ''): ?>
        <p style="color:red;"><?= e($error); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <label>Nama Barang</label><br>
        <input type="text" name="nama" required>
        <br><br>

        <label>Kategori</label><br>
        <input type="text" name="kategori" required>
        <br><br>

        <label>Harga Beli</label><br>
        <input type="number" name="harga_beli"
               min="0" step="0.01" required>
        <br><br>

        <label>Harga Jual</label><br>
        <input type="number" name="harga_jual"
               min="0" step="0.01" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Gambar Barang</label><br>
        <input type="file" name="file_gambar"
               accept=".jpg,.jpeg,.png,.webp">
        <br><br>

        <button type="submit">Simpan Barang</button>

        <a href="index.php?page=barang/list">Kembali</a>

    </form>
</section>
