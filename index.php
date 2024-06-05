<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <a href="insert.php" class="ml-auto"><button class="btn btn-success">Tambah Data</button></a>
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
                ini_set('display_errors', '1');
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
                          $search_query";
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
                            echo "<td><a class='btn btn-sm btn-danger' href='index.php?delete=" .($row['ID_Produk']) . "'>Delete</a></td>";
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
</body>
</html>
