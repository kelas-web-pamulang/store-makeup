<?php
session_start();

// Check if the session login or cookie login is set
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
    <title>Update Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('https://www.fdli.org/wp-content/uploads/2020/05/The-Regulation-of-Cosmetics-scaled.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 210vh;
            margin: 0;
        }

        .card {
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: pink;
        }

        .card-header h1 {
            margin: 0;
        }

        .btn-primary {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-primary:hover {
            background-color: #1e7e34;
            border-color: #1c7430;
        }

        /* Style for confirmation popup */
        .confirmation-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000; /* Ensure popup is above other elements */
            display: none; /* Hide initially */
        }

        .confirmation-popup.show {
            display: block; /* Show when triggered */
        }

        .confirmation-popup h2 {
            margin-top: 0;
        }

        .confirmation-popup .btn {
            margin-right: 10px;
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
    'traces_sample_rate' => 1.0,
    'profiles_sample_rate' => 1.0,
]);

require_once 'config_db.php';

$db = new ConfigDB();
$conn = $db->connect();

// Get product ID from query string
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$id) {
    echo "<div class='alert alert-danger mt-3' role='alert'>Invalid Product ID</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
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

    // Check if tambah_stok is set and valid
    $tambah_stok = isset($_POST['tambah_stok']) ? intval($_POST['tambah_stok']) : 0;
    if ($tambah_stok < 0) {
        $tambah_stok = 0;
    }

    // Check if kurangi_stok is set and valid
    $kurangi_stok = isset($_POST['kurangi_stok']) ? intval($_POST['kurangi_stok']) : 0;
    if ($kurangi_stok < 0) {
        $kurangi_stok = 0;
    }

    // Update stok
    $stok += $tambah_stok;
    $stok -= $kurangi_stok;

    if ($stok < 0) {
        $stok = 0; // Ensure stock is not negative
    }

    // Validate if stok is sufficient for reduction
    if ($kurangi_stok > $product['Stok']) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Stok yang akan dikurangi melebihi stok yang tersedia.</div>";
    } else {
        // Update query
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

        // Check query execution
        if ($query) {
            echo "<div class='alert alert-success mt-3' role='alert'>Data updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $conn->error . "</div>";
        }
    }
}

// Fetch product details
$result = $db->select("produk", ['AND ID_Produk=' => $id]);
if (empty($result)) {
    echo "<div class='alert alert-danger mt-3' role='alert'>Product not found. SQL: " . $db->getLastQuery() . "</div>";
    exit;
}
$product = $result[0];

// Close database connection
$db->close();
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-white text-center">
                    <h1>Ubah Data</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post" onsubmit="return validateStockReduction()">
                        <div class="form-group">
                            <label for="namaProdukInput">Nama Produk</label>
                            <input type="text" class="form-control" id="namaProdukInput" name="nama_produk"
                                   placeholder="Enter Product Name" required
                                   value="<?php echo htmlspecialchars($product['Nama_Produk']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="merekInput">Merek</label>
                            <input type="text" class="form-control" id="merekInput" name="merek"
                                   placeholder="Enter Brand" required
                                   value="<?php echo htmlspecialchars($product['Merek']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="kategoriInput">Kategori</label>
                            <input type="text" class="form-control" id="kategoriInput" name="kategori"
                                   placeholder="Enter Category" required
                                   value="<?php echo htmlspecialchars($product['Kategori']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="hargaInput">Harga</label>
                            <input type="number" class="form-control" id="hargaInput" name="harga"
                                   placeholder="Enter Price" required
                                   value="<?php echo htmlspecialchars($product['Harga']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="stokInput">Stok</label>
                            <input type="number" class="form-control" id="stokInput" name="stok"
                                   placeholder="Enter Stock" readonly
                                   value="<?php echo htmlspecialchars($product['Stok']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="tambahStokInput">Tambah Stok</label>
                            <input type="number" class="form-control" id="tambahStokInput" name="tambah_stok"
                                   placeholder="Enter Additional Stock" value="">
                        </div>
                        <div class="form-group">
                            <label for="kurangiStokInput">Kurangi Stok</label>
                            <input type="number" class="form-control" id="kurangiStokInput" name="kurangi_stok"
                                   placeholder="Enter Stock to Reduce" value="">
                        </div>
                        <div class="form-group">
                            <label for="tanggalKadaluarsaInput">Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control" id="tanggalKadaluarsaInput"
                                   name="tanggal_kadaluarsa"
                                   value="<?php echo htmlspecialchars($product['Tanggal_Kadaluarsa']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="bahanInput">Bahan</label>
                            <textarea class="form-control" id="bahanInput" name="bahan"
                                      placeholder="Enter Ingredients"><?php echo htmlspecialchars($product['Bahan']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="ukuranInput">Ukuran</label>
                            <input type="text" class="form-control" id="ukuranInput" name="ukuran"
                                   placeholder="Enter Size"
                                   value="<?php echo htmlspecialchars($product['Ukuran']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="ratingInput">Rating</label>
                            <input type="number" class="form-control" id="ratingInput" name="rating" step="0.1"
                                   min="0" max="5" placeholder="Enter Rating"
                                   value="<?php echo htmlspecialchars($product['Rating']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="sertifikasiInput">Sertifikasi</label>
                            <textarea class="form-control" id="sertifikasiInput" name="sertifikasi"
                                      placeholder="Enter Certifications"><?php echo htmlspecialchars($product['Sertifikasi']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        <a href="index.php" class="btn btn-info btn-block mt-2">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Popup -->
<div class="confirmation-popup" id="confirmationPopup">
    <h2>Konfirmasi</h2>
    <p id="confirmationMessage"></p>
    <button class="btn btn-primary" onclick="confirmAction()">Ya</button>
    <button class="btn btn-secondary" onclick="closeConfirmationPopup()">Tidak</button>
</div>

<script>
    function validateStockReduction() {
        var currentStock = <?php echo $product['Stok']; ?>;
        var kurangiStok = parseInt(document.getElementById('kurangiStokInput').value);

        if (kurangiStok > currentStock) {
            showConfirmationPopup('Stok yang akan dikurangi melebihi stok yang tersedia. Lanjutkan?', function() {
                document.querySelector('form').submit();
            });
            return false;
        }

        // Confirmation for adding stock
        var tambahStok = parseInt(document.getElementById('tambahStokInput').value);
        if (tambahStok < 0) {
            showConfirmationPopup('Anda yakin ingin menambahkan stok negatif?', function() {
                document.querySelector('form').submit();
            });
            return false;
        }

        return true;
    }

    function showConfirmationPopup(message, callback) {
        var popup = document.getElementById('confirmationPopup');
        var confirmationMessage = document.getElementById('confirmationMessage');
        confirmationMessage.textContent = message;
        popup.style.display = 'block';

        // Store callback globally to be called later
        window.confirmationCallback = callback;
    }

    function confirmAction() {
        if (window.confirmationCallback) {
            window.confirmationCallback();
        }
        closeConfirmationPopup();
    }

    function closeConfirmationPopup() {
        var popup = document.getElementById('confirmationPopup');
        popup.style.display = 'none';
    }
</script>

</body>
</html>
