<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Register - Cat Shop</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<header>
    <h1>
        <a href="index.php" class="logo"> Cat Shop</a>
    </h1>

    <nav class="nav-icons">
        <a href="login.php" class="user-icon">👤</a>
        <a href="cart.php" class="cart-icon">🛒</a>
    </nav>
</header>

<main class="center-page">
    <div class="center-box login-box">
        <h2>Εγγραφή</h2>

        <form>
            <label>Όνομα</label>
            <input type="text" placeholder="Το όνομά σας">

            <label>Email</label>
            <input type="email" placeholder="email@example.com">

            <label>Κωδικός</label>
            <input type="password" placeholder="********">

            <label>Επιβεβαίωση Κωδικού</label>
            <input type="password" placeholder="********">

            <button type="submit" class="login-btn">Εγγραφή</button>
        </form>

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
