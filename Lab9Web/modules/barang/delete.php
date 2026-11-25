
<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "<section class='content'>Metode permintaan tidak diizinkan.</section>";
    return;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    echo "<section class='content'>ID barang tidak valid.</section>";
    return;
}

// Mengambil nama gambar sebelum data dihapus
$stmt = mysqli_prepare(
    $conn,
    "SELECT gambar FROM data_barang WHERE id_barang = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$barang) {
    echo "<section class='content'>Barang tidak ditemukan.</section>";
    return;
}

// Menghapus data dari database
$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM data_barang WHERE id_barang = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    // Menghapus file gambar jika ada
    if (!empty($barang['gambar']) &&
        str_starts_with($barang['gambar'], 'gambar/')) {

        $fileGambar = __DIR__ . '/../../' . $barang['gambar'];

        if (is_file($fileGambar)) {
            unlink($fileGambar);
        }
    }

    mysqli_stmt_close($stmt);

    header("Location: index.php?page=barang/list");
    exit;

} else {

    mysqli_stmt_close($stmt);

    echo "<section class='content'>Data gagal dihapus.</section>";
}

?>
