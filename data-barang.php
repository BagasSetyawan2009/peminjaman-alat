<form method="POST" action="proses-pinjam.php">

    <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>">

    <input type="number" name="jml_barang" min="1" required>

    <button type="submit">Pinjam</button>

</form>