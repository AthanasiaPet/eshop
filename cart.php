<?php
session_start();
require_once "includes/db.php";

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(",", array_keys($cart));

    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Καλάθι - Cat Shop</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/cart.css">
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
    <div class="center-box cart-box">
        <h2>Το καλάθι σας</h2>

        <?php if (empty($cart)): ?>
            <p>Το καλάθι είναι άδειο 🐾</p>
            <a href="shop.php" class="shop-link">Πίσω στο κατάστημα</a>

        <?php else: ?>

            <table class="cart-table">
                <tr>
                    <th>Προϊόν</th>
                    <th>Τιμή</th>
                    <th>Ποσότητα</th>
                    <th>Σύνολο</th>
                </tr>

                <?php foreach ($products as $product): 
                    $qty = $cart[$product['id']];
                    $sum = $qty * $product['price'];
                    $total += $sum;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>€<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $qty; ?></td>
                    <td>€<?php echo number_format($sum, 2); ?></td>
                </tr>
                <?php endforeach; ?>

                <tr class="total-row">
                    <td colspan="3"><strong>Σύνολο</strong></td>
                    <td><strong>€<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </table>

        <?php endif; ?>

    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>

</body>
</html>
