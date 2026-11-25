<?php
require_once __DIR__ . '/../helpers/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengujian Function</title>
</head>
<body>

<h1>Pengujian Function PHP</h1>

<h3>1. Format Rupiah</h3>
<p><?php echo formatRupiah(500000); ?></p>

<h3>2. Validasi Email</h3>

<?php
$email = "chelsea@gmail.com";

if (validasiEmail($email)) {
    echo "Email valid";
} else {
    echo "Email tidak valid";
}
?>

<h3>3. Ringkasan Teks</h3>

<p>
<?php
echo e(ringkasTeks(
    "Saya sedang belajar pemrograman web menggunakan PHP Modular",
    25
));
?>
</p>

<h3>4. Perhitungan Diskon</h3>

<p>
Harga awal: <?php echo formatRupiah(200000); ?>
</p>

<p>
Diskon: <?php echo formatRupiah(hitungDiskon(200000)); ?>
</p>

</body>
</html>
