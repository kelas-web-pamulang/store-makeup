<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        if (!$id) {
            echo "<div class='alert alert-danger mt-3' role='alert'>Invalid Product ID</div>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_produk = $_POST['nama_produk'];
            $merek = $_POST['merek'];
            $kategori = $_POST['kategori'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];
            $bahan = $_POST['bahan'];
            $ukuran = $_POST['ukuran'];
            $rating = $_POST['rating'];
            $sertifikasi = $_POST['sertifikasi'];

            $query = $db->update('produk', [
                'Nama_Produk' => $nama_produk,
                'Merek' => $merek,
                'Kategori' => $kategori,
                'Harga' => $harga,
                'Stok' => $stok,
                'Tanggal_Kadaluarsa' => $tanggal_kadaluarsa,
                'Bahan' => $bahan,
                'Ukuran' => $ukuran,
                'Rating' => $rating,
                'Sertifikasi' => $sertifikasi
            ], $id);

            if ($query) {
                echo "<div class='alert alert-success mt-3' role='alert'>Data updated successfully</div>";
            } else {
                echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $conn->error . "</div>";
            }
        }

        $result = $db->select("produk", ['AND ID_Produk=' => $id]);
        if (empty($result)) {
            echo "<div class='alert alert-danger mt-3' role='alert'>Product not found. SQL: " . $db->getLastQuery() . "</div>";
            exit;
        }
        $product = $result[0];

        $db->close();
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Ubah Data</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="namaProdukInput">Nama Produk</label>
                <input type="text" class="form-control" id="namaProdukInput" name="nama_produk" placeholder="Enter Product Name" required value="<?php echo htmlspecialchars($product['Nama_Produk']); ?>">
            </div>
            <div class="form-group">
                <label for="merekInput">Merek</label>
                <input type="text" class="form-control" id="merekInput" name="merek" placeholder="Enter Brand" required value="<?php echo htmlspecialchars($product['Merek']); ?>">
            </div>
            <div class="form-group">
                <label for="kategoriInput">Kategori</label>
                <input type="text" class="form-control" id="kategoriInput" name="kategori" placeholder="Enter Category" required value="<?php echo htmlspecialchars($product['Kategori']); ?>">
            </div>
            <div class="form-group">
                <label for="hargaInput">Harga</label>
                <input type="number" class="form-control" id="hargaInput" name="harga" placeholder="Enter Price" required value="<?php echo htmlspecialchars($product['Harga']); ?>">
            </div>
            <div class="form-group">
                <label for="stokInput">Stok</label>
                <input type="number" class="form-control" id="stokInput" name="stok" placeholder="Enter Stock" required value="<?php echo htmlspecialchars($product['Stok']); ?>">
            </div>
            <div class="form-group">
                <label for="tanggalKadaluarsaInput">Tanggal Kadaluarsa</label>
                <input type="date" class="form-control" id="tanggalKadaluarsaInput" name="tanggal_kadaluarsa" value="<?php echo htmlspecialchars($product['Tanggal_Kadaluarsa']); ?>">
            </div>
            <div class="form-group">
                <label for="bahanInput">Bahan</label>
                <textarea class="form-control" id="bahanInput" name="bahan" placeholder="Enter Ingredients"><?php echo htmlspecialchars($product['Bahan']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="ukuranInput">Ukuran</label>
                <input type="text" class="form-control" id="ukuranInput" name="ukuran" placeholder="Enter Size" value="<?php echo htmlspecialchars($product['Ukuran']); ?>">
            </div>
            <div class="form-group">
                <label for="ratingInput">Rating</label>
                <input type="number" class="form-control" id="ratingInput" name="rating" step="0.1" min="0" max="5" placeholder="Enter Rating" value="<?php echo htmlspecialchars($product['Rating']); ?>">
            </div>
            <div class="form-group">
                <label for="sertifikasiInput">Sertifikasi</label>
                <textarea class="form-control" id="sertifikasiInput" name="sertifikasi" placeholder="Enter Certifications"><?php echo htmlspecialchars($product['Sertifikasi']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-info">Kembali</a>
        </form>
    </div>
</body>
</html>
