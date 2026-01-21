<?php
session_start();
require_once "includes/db.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
     if (!$name || !$email || !$password || !$confirm) {
        $message = "Παρακαλώ συμπληρώστε όλα τα πεδία.";
    } elseif ($password !== $confirm) {
        $message = "Οι κωδικοί δεν ταιριάζουν.";
    } else {
        
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $message = "Υπάρχει ήδη λογαριασμός με αυτό το email.";
        } else {
            
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hash])) {
                header("Location: login.php?registered=1");
            exit;
            } else {
                $message = "Κάτι πήγε στραβά. Προσπαθήστε ξανά.";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Register - Cat Shop</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
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
        <h2>Εγγραφή</h2>
    

        <form method="post" action="">
            <label>Όνομα</label>
            <input type="text" placeholder="Το όνομά σας"  name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>

            <label>Email</label>
            <input type="email" placeholder="email@example.com" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label>Κωδικός</label>
            <input type="password" placeholder="********" name="password" required>

            <label>Επιβεβαίωση Κωδικού</label>
            <input type="password" placeholder="********"  name="confirm" required>

            <button type="submit" class="login-btn">Εγγραφή</button>
        </form>

        <?php if($message): ?>
            <p class="form-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <p class="register-link">
            Έχετε ήδη λογαριασμό;
            <a href="login.php">Σύνδεση</a>
        </p>
    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>

</body>
</html>
