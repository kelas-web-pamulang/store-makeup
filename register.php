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
            background-color: #d63384
            background-size: cover;
            font-family: 'Georgia', serif;
            color: #444;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #d63384;
            font-family: 'Cursive', sans-serif;
        }
        .form-control {
            border: 1px solid #d63384;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #d63384;
            border-color: #d63384;
            border-radius: 10px;
        }
        .btn-secondary {
            background-color: #d63384;
            border-color: #d63384;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #bf265e;
            border-color: #bf265e;
        }
        .alert-success {
            background-color: #ffd6e7;
            color: #d63384;
        }
        .alert-danger {
            background-color: #ffd6e7;
            color: #d63384;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Register Page</h1>
        <form action="" method="post">
            <div class="form-group">
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
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
        <?php
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);

            require_once 'config_db.php';

            $db = new ConfigDB();
            $conn = $db->connect();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $tgl_buat = date('Y-m-d H:i:s');

                $query = "INSERT INTO user (email, full_name, passsword, role, tgl_buat) VALUES ('$email', '$name', '$password', 'admin', '$tgl_buat')";
                $queryExecute = $conn->query($query);


                if ($queryExecute) {
                    echo "<div class='alert alert-success mt-3' role='alert'>Data inserted successfully</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
                }
            }
        ?>
    </div>
</body>
</html>