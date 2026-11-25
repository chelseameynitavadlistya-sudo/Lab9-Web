
<?php
$query = mysqli_query(
    $conn,
    "SELECT * FROM data_barang ORDER BY id_barang DESC"
);
?>

<section class="content">
    <h2>Data Barang</h2>

    <p>Daftar barang yang tersimpan dalam database.</p>

    <a href="index.php?page=barang/add">
        + Tambah Barang
    </a>

    <br><br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($row = mysqli_fetch_assoc($query)):
        ?>

        <tr>
            <td><?= $no++; ?></td>

            <td>
                <?= htmlspecialchars($row['nama']); ?>
            </td>

            <td>
                <?= htmlspecialchars($row['kategori']); ?>
            </td>

            <td>
                Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?>
            </td>

            <td>
                Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?>
            </td>

            <td>
                <?= (int)$row['stok']; ?>
            </td>

            <td>
                <a href="index.php?page=barang/edit&id=<?= (int)$row['id_barang']; ?>">
                    Edit
                </a>

                |

                <form method="post"
                      action="index.php?page=barang/delete"
                      onsubmit="return confirm('Yakin ingin menghapus barang ini?');"
                      style="display:inline;">

                    <input type="hidden"
                           name="id"
                           value="<?= (int)$row['id_barang']; ?>">

                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>

        <?php endwhile; ?>

    </table>
</section>
