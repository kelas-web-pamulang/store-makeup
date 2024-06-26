<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('clientId', '', time() - 3600, '/');
    setcookie('clientSecret', '', time() - 3600, '/');
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
    <title>List Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: url('https://www.fdli.org/wp-content/uploads/2020/05/The-Regulation-of-Cosmetics-scaled.jpeg') no-repeat center center fixed; 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120vh;
            margin: 0;
        }
        .container {
            margin-top: 50px;
        }
        h1 {
            color: #6c757d;
            font-family: 'Georgia', serif;
            margin-bottom: 30px;
        }
        .form-control, .form-select {
            border-radius: 20px;
        }
        .btn-success, .btn-danger, .btn-info {
            border-radius: 20px;
        }
        .table {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }
        .table th {
            background-color: #d63384;
            color: #ffffff;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .alert {
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">List Product</h1>
        <div class="row">
            <div class="d-flex justify-content-between mb-3">
                <form action="" method="get" class="d-flex align-items-center">
                    <input class="form-control" placeholder="Cari Data" name="search"/>
                    <select name="search_by" class="form-select">
                        <option value="">Search All</option>
                        <option value="Nama_Produk">Name</option>
                        <option value="Kategori">Category</option>
                    </select>
                    <button type="submit" class="btn btn-success mx-2">Cari</button>
                </form>
                <div>
                    <a href="insert.php" class="btn btn-success">Tambah Data</a>
                    <a href="?logout" class="btn btn-danger">Logout</a>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>ID_Produk</th>
                    <th>Nama_Produk</th>
                    <th>Merek</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tanggal_Kadaluarsa</th>
                    <th>Bahan</th>
                    <th>Ukuran</th>
                    <th>Rating</th>
                    <th>Sertifikasi</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php

                require 'vendor/autoload.php';
                \Sentry\init([
                    'dsn' => 'https://848c81bfebd9037f8437713ec9c03931@o4507457086619648.ingest.us.sentry.io/4507457091862528',
                    'traces_sample_rate' => 1.0,
                    'profiles_sample_rate' => 1.0,
                ]);

                date_default_timezone_set('Asia/Jakarta');
                ini_set('display_errors', '0');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once 'config_db.php';
                $db = new ConfigDB();
                $conn = $db->connect();

                $search_query = "WHERE a.deleted_at IS NULL";
                if (isset($_GET['search']) && $_GET['search'] !== "") {
                    $search = $conn->real_escape_string($_GET['search']);
                    $search_by = $conn->real_escape_string($_GET['search_by']);
                    if ($search_by === "Nama_Produk") {
                        $search_query .= " AND a.Nama_Produk LIKE '%$search%'";
                    } elseif ($search_by === "Kategori") {
                        $search_query .= " AND b.Kategori LIKE '%$search%'";
                    } else {
                        $search_query .= " AND (a.Nama_Produk LIKE '%$search%' OR b.Kategori LIKE '%$search%')";
                    }
                }

                if (isset($_GET['delete'])) {
                    $delete_id = $conn->real_escape_string($_GET['delete']);
                    $delete_query = "UPDATE produk SET deleted_at = NOW() WHERE ID_Produk = $delete_id";
                    if (!$conn->query($delete_query)) {
                        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
                    }
                }

                $query = "SELECT a.ID_Produk, a.Nama_Produk, a.Merek, a.Harga, a.Stok, a.Tanggal_Kadaluarsa, a.Bahan, a.Ukuran, a.Rating, a.Sertifikasi, a.created_at, b.Kategori AS category_name 
                          FROM produk a
                          LEFT JOIN categories b ON a.Kategori = b.ID_Kategori 
                          $search_query
                          ORDER BY a.created_at DESC";  // Added ORDER BY clause
                $result = $conn->query($query);

                if ($result) {
                    $totalRows = $result->num_rows;

                    if ($totalRows > 0) {
                        $key = 1;  // Initialize the $key variable
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" .($row['ID_Produk']) . "</td>";
                            echo "<td>" . ($row['Nama_Produk']) . "</td>";
                            echo "<td>" . ($row['Merek']) . "</td>";
                            echo "<td>" . ($row['category_name']) . "</td>";
                            echo "<td>" .($row['Harga']) . "</td>";
                            echo "<td>" . ($row['Stok']) . "</td>";
                            echo "<td>" . ($row['Tanggal_Kadaluarsa']) . "</td>";
                            echo "<td>" . ($row['Bahan']) . "</td>";
                            echo "<td>" .($row['Ukuran']) . "</td>";
                            echo "<td>" .($row['Rating']) . "</td>";
                            echo "<td>" .($row['Sertifikasi']) . "</td>";
                            echo "<td>" .($row['created_at']) . "</td>";
                            echo "<td><a class='btn btn-sm btn-info' href='update.php?id=" .($row['ID_Produk']) . "'>Update</a></td>";
                            echo "<td><a class='btn btn-sm btn-danger' href='#' onclick='confirmDelete(" .($row['ID_Produk']) . ")'>Delete</a></td>";
                            echo "</tr>";
                            $key++;  // Increment the $key variable
                        }
                    } else {
                        echo "<tr><td colspan='13' class='text-center'>No data found</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='13' class='text-center'>Error: " . $conn->error . "</td></tr>";
                }

                $db->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm('Apakah kamu yakin ingin menghapus data?')) {
                window.location.href = 'index.php?delete=' + id;
            }
        }
    </script>
</body>

</html>
