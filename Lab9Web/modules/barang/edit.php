
<?php
$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM data_barang WHERE id_barang = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$barang) {
    echo "<section class='content'><h2>Barang tidak ditemukan.</h2></section>";
    return;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $harga_beli = (float)($_POST['harga_beli'] ?? 0);
    $harga_jual = (float)($_POST['harga_jual'] ?? 0);
    $stok = (int)($_POST['stok'] ?? 0);

    $gambar = $barang['gambar'];

    if ($nama === '' || $kategori === '' ||
        $harga_beli < 0 || $harga_jual < 0 || $stok < 0) {

        $error = "Data tidak boleh kosong atau bernilai negatif.";

    } else {

        if (!empty($_FILES['file_gambar']['name'])) {

            $tmpFile = $_FILES['file_gambar']['tmp_name'];
            $ukuran = $_FILES['file_gambar']['size'];

            $ekstensi = strtolower(
                pathinfo($_FILES['file_gambar']['name'], PATHINFO_EXTENSION)
            );

            if (!in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']) ||
                $ukuran > 2 * 1024 * 1024 ||
                !is_uploaded_file($tmpFile)) {

                $error = "Format gambar tidak sesuai atau ukuran lebih dari 2 MB.";

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
                "UPDATE data_barang
                SET nama=?, kategori=?, harga_beli=?,
                    harga_jual=?, stok=?, gambar=?
                WHERE id_barang=?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssddisi",
                $nama,
                $kategori,
                $harga_beli,
                $harga_jual,
                $stok,
                $gambar,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                if ($gambar !== $barang['gambar'] &&
                    str_starts_with($barang['gambar'], 'gambar/')) {

                    $fileLama = __DIR__ . '/../../' . $barang['gambar'];

                    if (is_file($fileLama)) {
                        unlink($fileLama);
                    }
                }

                header("Location: index.php?page=barang/list");
                exit;

            } else {
                $error = "Data gagal diperbarui.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<section class="content">
    <h2>Edit Barang</h2>

    <?php if ($error !== ''): ?>
        <p style="color:red;"><?= e($error); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <label>Nama Barang</label><br>
        <input type="text" name="nama"
               value="<?= e($barang['nama']); ?>" required>
        <br><br>

        <label>Kategori</label><br>
        <input type="text" name="kategori"
               value="<?= e($barang['kategori']); ?>" required>
        <br><br>

        <label>Harga Beli</label><br>
        <input type="number" name="harga_beli"
               value="<?= e((string)$barang['harga_beli']); ?>"
               min="0" step="0.01" required>
        <br><br>

        <label>Harga Jual</label><br>
        <input type="number" name="harga_jual"
               value="<?= e((string)$barang['harga_jual']); ?>"
               min="0" step="0.01" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok"
               value="<?= (int)$barang['stok']; ?>"
               min="0" required>
        <br><br>

        <label>Ganti Gambar</label><br>
        <input type="file" name="file_gambar"
               accept=".jpg,.jpeg,.png,.webp">
        <br><br>

        <button type="submit">Update Barang</button>

        <a href="index.php?page=barang/list">Kembali</a>

    </form>
</section>
