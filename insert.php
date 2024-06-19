<?php
session_start();

if (!isset($_SESSION['login']) && !isset($_COOKIE['login'])) {
    header('Location: login.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('https://i.pinimg.com/736x/0f/55/9d/0f559dc377c4aa7af5502696e9f98dbb.jpg') no-repeat center center fixed; 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200vh;
            margin: 0;
        }
        .container {
            background-color: pink;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            margin-bottom: 10px;
        }
        .btn-primary, .btn-success {
            margin-top: 100px;
        }
        .alert {
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <?php
    date_default_timezone_set('Asia/Jakarta');
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        require 'vendor/autoload.php';
        \Sentry\init([
            'dsn' => 'https://848c81bfebd9037f8437713ec9c03931@o4507457086619648.ingest.us.sentry.io/4507457091862528',
            // Specify a fixed sample rate
            'traces_sample_rate' => 1.0,
            // Set a sampling rate for profiling - this is relative to traces_sample_rate
            'profiles_sample_rate' => 1.0,
        ]);

        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();
    ?>
<div class="container">
    <h1 class="text-center mt-5">Insert Data Produk</h1>
    <form action="" method="post" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="namaProdukInput">Nama Produk</label>
            <input type="text" class="form-control" id="namaProdukInput" name="Nama_Produk" placeholder="Enter Product Name" required>
            <div class="invalid-feedback">Nama produk diperlukan.</div>
        </div>
        <div class="form-group">
            <label for="merekInput">Merek</label>
            <input type="text" class="form-control" id="merekInput" name="Merek" placeholder="Enter Brand" required>
            <div class="invalid-feedback">Merek diperlukan.</div>
        </div>
        <div class="form-group">
            <label for="kategoriInput">Kategori</label>
            <input type="text" class="form-control" id="kategoriInput" name="Kategori" placeholder="Enter Category" required>
            <div class="invalid-feedback">Kategori diperlukan.</div>
        </div>
        <div class="form-group">
            <label for="hargaInput">Harga</label>
            <input type="number" class="form-control" id="hargaInput" name="Harga" placeholder="Enter Price" required>
            <div class="invalid-feedback">Harga diperlukan.</div>
        </div>
        <div class="form-group">
            <label for="stokInput">Stok</label>
            <input type="number" class="form-control" id="stokInput" name="Stok" placeholder="Enter Stock" required>
            <div class="invalid-feedback">Stok diperlukan.</div>
        </div>
        <div class="form-group">
            <label for="tanggalKadaluarsaInput">Tanggal Kadaluarsa</label>
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

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

</body>
</html>
