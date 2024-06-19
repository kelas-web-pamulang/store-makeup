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
            background: url('https://img.pikbest.com/wp/202344/cosmetic-makeup-glamorous-branding-and-art-luxurious-beige-texture-background-for-skincare-cosmetics_9917527.jpg!sw800') no-repeat center center fixed; 
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
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00d4ff);
            border: none;
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
        .mt-5 {
            margin-top: 3rem !important;
        }
        .card-header {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .alert {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card p-4" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center">
                <h1>Login</h1>
            </div>
            <form action="" method="post">
                <div class="form-group mt-3">
                    <label for="emailInput">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                <a href = "register.php" class = "btn btn-secondary mt-5 w-100">Register</a>
            </form>
            <?php
                date_default_timezone_set('Asia/Jakarta');
                ini_set('display_errors', '0');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                session_start();
                if (isset($_SESSION['login'])) {
                    header('Location: index.php');
                    exit();
                }

                require_once 'config_db.php';
                require 'vendor/autoload.php';
        \Sentry\init([
        'dsn' => 'https://848c81bfebd9037f8437713ec9c03931@o4507457086619648.ingest.us.sentry.io/4507457091862528',
        // Specify a fixed sample rate
        'traces_sample_rate' => 1.0,
        // Set a sampling rate for profiling - this is relative to traces_sample_rate
        'profiles_sample_rate' => 1.0,
        ]);
                

                $db = new ConfigDB();
                $conn = $db->connect();

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $query = "SELECT id, email, full_name, password FROM users WHERE email = '$email'";
                    $queryExecute = $conn->query($query);

                    if ($queryExecute->num_rows > 0) {
                        $user = $queryExecute->fetch_assoc();
                        $isPasswordMatch = password_verify($password, $user['password']);
                        if ($isPasswordMatch) {
                            $_SESSION['login'] = true;
                            $_SESSION['userId'] = $user['id'];
                            $_SESSION['userName'] = $user['full_name'];

                            // Setting cookies
                            setcookie('login', 'true', time() + 86400 * 30, '/');
                            setcookie('clientId', $user['id'], time() + 86400 * 30, '/');
                            setcookie('clientSecret', hash('sha256', $user['email']), time() + 86400 * 30, '/');

                            header('Location: index.php');
                            exit();
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>User/Password is incorrect</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>User/Password is incorrect</div>";
                    }
                }

                $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
