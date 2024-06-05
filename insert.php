<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();
    ?>
<div class="container">
    <h1 class="text-center mt-5">Insert Data Produk</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="namaProdukInput">Nama_Produk</label>
            <input type="text" class="form-control" id="namaProdukInput" name="Nama_Produk" placeholder="Enter Product Name" required>
        </div>
        <div class="form-group">
            <label for="merekInput">Merek</label>
            <input type="text" class="form-control" id="merekInput" name="Merek" placeholder="Enter Brand" required>
        </div>
        <div class="form-group">
            <label for="kategoriInput">Kategori</label>
            <input type="text" class="form-control" id="kategoriInput" name="Kategori" placeholder="Enter Category" required>
        </div>
        <div class="form-group">
            <label for="hargaInput">Harga</label>
            <input type="number" class="form-control" id="hargaInput" name="Harga" placeholder="Enter Price" required>
        </div>
        <div class="form-group">
            <label for="stokInput">Stok</label>
            <input type="number" class="form-control" id="stokInput" name="Stok" placeholder="Enter Stock" required>
        </div>
        <div class="form-group">
            <label for="tanggalKadaluarsaInput">Tanggal_Kadaluarsa</label>
            <input type="date" class="form-control" id="tanggalKadaluarsaInput" name="Tanggal_Kadaluarsa">
        </div>
        <div class="form-group">
            <label for="bahanInput">Bahan</label>
            <textarea class="form-control" id="bahanInput" name="Bahan" placeholder="Enter Ingredients"></textarea>
        </div>
        <div class="form-group">
            <label for="ukuranInput">Ukuran</label>
            <input type="text" class="form-control" id="ukuranInput" name="Ukuran" placeholder="Enter Size">
        </div>
        <div class="form-group">
            <label for="ratingInput">Rating</label>
            <input type="number" class="form-control" id="ratingInput" name="Rating" step="0.1" min="0" max="5" placeholder="Enter Rating">
        </div>
        <div class="form-group">
            <label for="sertifikasiInput">Sertifikasi</label>
            <textarea class="form-control" id="sertifikasiInput" name="Sertifikasi" placeholder="Enter Certifications"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="index.php" class="btn btn-success">Kembali</a>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_produk = $_POST['Nama_Produk'];
            $merek = $_POST['Merek'];
            $kategori = $_POST['Kategori'];
            $harga = $_POST['Harga'];
            $stok = $_POST['Stok'];
            $tanggal_kadaluarsa = $_POST['Tanggal_Kadaluarsa'];
            $bahan = $_POST['Bahan'];
            $ukuran = $_POST['Ukuran'];
            $rating = $_POST['Rating'];
            $sertifikasi = $_POST['Sertifikasi'];
            $created_at = date('Y-m-d H:i:s');

        
            $query = "INSERT INTO Produk (Nama_Produk, Merek, Kategori, Harga, Stok, Tanggal_Kadaluarsa, Bahan, Ukuran, Rating, Sertifikasi, created_at)
            VALUES ('$nama_produk', '$merek', '$kategori', '$harga', '$stok', '$tanggal_kadaluarsa', '$bahan', '$ukuran', '$rating', '$sertifikasi', '$created_at')";

if ($conn->query($query) === TRUE) {
    echo "<div class='alert alert-success mt-3' role='alert'>Data inserted successfully</div>";
} else {
    echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
}
}
$conn->close();
?>
</div>
