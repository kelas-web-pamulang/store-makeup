<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: url('https://i.pinimg.com/736x/f7/e3/bc/f7e3bce0bb31b3fbce4339fd90a37849.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Georgia', serif;
            color: #444;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
            background-color: rgba(253, 253, 253, 0.9); 
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
        .alert-danger {
            background-color: #ffd6e7;
            color: #d63384;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Login Page</h1>
        <form action="" method="post">
            <div class="form-group mt-3">
                <label for="emailInput">Email</label>
                <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-group mt-3">
                <label for="passwordInput">Password</label>
                <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-5 w-100">Login</button>
            <a href="register.php" class="btn btn-secondary mt-5 w-100">Register</a>
        </form>
        <?php
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);

            session_start();
            if (isset($_SESSION['login'])) {
                header('Location: index.php');
                exit();
            }

            require_once 'config_db.php';

            $db = new ConfigDB();
            $conn = $db->connect();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $query = "SELECT id, email, full_name, passsword FROM user WHERE email = '$email'";
                $queryExecute = $conn->query($query);

                if ($queryExecute->num_rows > 0) {
                    $user = $queryExecute->fetch_assoc();
                    $isPasswordMatch = password_verify($password, $user['passsword']);
                    if ($isPasswordMatch) {
                        $_SESSION['login'] = true;
                        $_SESSION['userId'] = $user['id'];
                        $_SESSION['userName'] = $user['full_name'];

                        setcookie('clientId', $user['id'], time() + 86400, '/');
                        setcookie('clientSecret', hash('sha256', $user['email']), time() + 86400, '/');
                        header('Location: index.php');
                        exit();
                    } else {
                        echo "<div class='alert alert-danger mt-3' role='alert'>User/Password is incorrect</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>User/Password is incorrect</div>";
                }
            }
        ?>
    </div>
</body>
</html>
