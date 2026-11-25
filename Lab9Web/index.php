
<?php

ob_start();

// Memanggil function
require_once __DIR__ . '/helpers/functions.php';

// Memanggil koneksi database
require_once __DIR__ . '/config/database.php';

// Daftar halaman yang diizinkan
$routes = [

    'dashboard' => __DIR__ . '/views/dashboard.php',

    'user/list' => __DIR__ . '/modules/user/list.php',
    'user/add' => __DIR__ . '/modules/user/add.php',
    'user/edit' => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',

    'auth/login' => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',

    'barang/list' => __DIR__ . '/modules/barang/list.php',
    'barang/add' => __DIR__ . '/modules/barang/add.php',
    'barang/edit' => __DIR__ . '/modules/barang/edit.php',
    'barang/delete' => __DIR__ . '/modules/barang/delete.php'

];

// Membaca parameter halaman
$page = $_GET['page'] ?? 'dashboard';

// Memeriksa rute
if (!is_string($page) || !array_key_exists($page, $routes)) {

    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';

} else {

    $contentFile = $routes[$page];

}

// Memanggil template
require_once __DIR__ . '/views/header.php';

require $contentFile;

require_once __DIR__ . '/views/footer.php';

ob_end_flush();

?>
