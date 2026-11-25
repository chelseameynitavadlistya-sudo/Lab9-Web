<?php

// 1. Function tanpa parameter
function tampilkanSalam(): string {
    return "Selamat belajar PHP Modular!";
}

// 2. Function dengan parameter
function sapaPengguna(string $nama): string {
    return "Halo, " . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
}

// 3. Function dengan return
function hitungLuasPersegiPanjang(float $panjang, float $lebar): float {
    return $panjang * $lebar;
}

// 4. Function menghitung diskon
function hitungDiskon(float $harga, float $persen = 10): float {
    return $harga * ($persen / 100);
}

// 5. Function format Rupiah
function formatRupiah(float $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// 6. Function validasi email
function validasiEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 7. Function meringkas teks
function ringkasTeks(string $teks, int $maksimal = 30): string {
    if (strlen($teks) > $maksimal) {
        return substr($teks, 0, $maksimal) . '...';
    }

    return $teks;
}

// 8. Function konversi Celsius ke Fahrenheit
function konversiCelciusKeFahrenheit(float $c): float {
    return ($c * 9 / 5) + 32;
}

// 9. Function menentukan status nilai
function tentukanStatusNilai(float $nilai): string {
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 75) {
        return "B";
    } elseif ($nilai >= 60) {
        return "C";
    } else {
        return "D";
    }
}

// 10. Function menghitung total belanja
function hitungTotal(float $harga, int $jumlah): float {
    return $harga * $jumlah;
}

// 11. Function keamanan output HTML
function e(string $nilai): string {
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

?>
