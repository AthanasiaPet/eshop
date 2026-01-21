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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
</head>
<body>

<header>
    <h1>
        <a href="index.php" class="logo"> Cat Shop</a>
    </h1>

    <nav>
        
        <a href="login.php" class="user-icon">
            <i class="fa-regular fa-user"></i>
        </a>

        <a href="cart.php" class="cart-icon">
            <i class="fa-solid fa-cart-shopping"></i>
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
