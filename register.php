<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: index.php');
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
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: url('https://c4.wallpaperflare.com/wallpaper/638/601/313/lipstick-shadows-black-background-brush-cosmetics-hd-wallpaper-preview.jpg') no-repeat center center fixed; 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            padding: 20px;
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 30px;
            padding: 10px 20px;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00d4ff);
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn-secondary {
            background: linear-gradient(45deg, #007bff, #00d4ff);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #009edb);
        }
        .text-center {
            margin-top: 2rem;
        }
        .card-header {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
            text-align: center;
        }
        .alert {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4">
            <div class="card-header">
                <h1>Register</h1>
            </div>
            <form action="" method="post">
                <div class="form-group mt-3">
                    <label for="nameInput">Name</label>
                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label for="emailInput">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                <a href = "login.php" class = "btn btn-secondary mt-5 w-100">Login</a>

            </form>
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

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $tgl_buat = date('Y-m-d H:i:s');

                    $query = "INSERT INTO users (email, full_name, password, role, tgl_buat) VALUES ('$email', '$name', '$password', 'admin', '$tgl_buat')";
                    $queryExecute = $conn->query($query);

                    if ($queryExecute) {
                        echo "<div class='alert alert-success mt-3' role='alert'>Data inserted successfully</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
