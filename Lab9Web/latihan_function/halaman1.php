<?php
require_once __DIR__ . '/../helpers/functions.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Latihan Function PHP</title>
</head>
<body>

<h1>Latihan Function PHP</h1>

<h3>1. Function tanpa parameter</h3>
<p><?php echo tampilkanSalam(); ?></p>

<h3>2. Function dengan parameter</h3>
<p><?php echo sapaPengguna("Chelsea"); ?></p>

<h3>3. Function dengan return</h3>
<p>
    Luas persegi panjang:
    <?php echo hitungLuasPersegiPanjang(8, 5); ?>
</p>

<h3>4. Function menghitung diskon</h3>
<p>
    Diskon:
    <?php echo formatRupiah(hitungDiskon(200000, 15)); ?>
</p>

<h3>5. Function konversi suhu</h3>
<p>
    30 Celcius =
    <?php echo konversiCelciusKeFahrenheit(30); ?>
    Fahrenheit
</p>

<h3>6. Function status nilai</h3>
<p>
    Nilai 90 mendapatkan predikat:
    <?php echo tentukanStatusNilai(90); ?>
</p>

<h3>7. Function total belanja</h3>
<p>
    Total belanja:
    <?php echo formatRupiah(hitungTotal(15000, 3)); ?>
</p>

</body>
</html>
