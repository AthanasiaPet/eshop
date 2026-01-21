<?php
session_start();
require_once "includes/db.php"; 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: shop.php"); 
        exit;
    } else {
        $error = "Λάθος email ή κωδικός";
    }
}

if (isset($_SESSION['user_id'])) {
    header("Location: shop.php"); 
    exit;
}
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Login - Cat Shop</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css?v=2">
</head>
<body>

<header>
    <h1>
        <a href="index.php" class="logo"> Cat Shop</a>
    </h1>

    <nav>
        
        <a href="login.php" class="user-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="user-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
        </a>

        <a href="cart.php" class="cart-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="cart-icon">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
        </a>
    </nav>
</header>

<main class="center-page">
    <div class="center-box login-box">

    <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">
            Επιτυχής δημιουργία λογαριασμού! Παρακαλώ συνδεθείτε
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php endif; ?>


        <h2>Σύνδεση</h2>

        <form method="POST" >
            <label>Email</label>
            <input type="email" placeholder="email@example.com" name="email" required>

            <label>Κωδικός</label>
            <input type="password" placeholder="********" name="password" required>

            <button type="submit">Σύνδεση</button>
        </form>

        <p class="register-link">
            Δεν έχετε λογαριασμό;
            <a href="register.php">Εγγραφή</a>
        </p>
    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>

</body>
</html>
