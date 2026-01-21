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
    <div class="center-box cart-box">
        <h2>Το καλάθι σας</h2>

        <?php if (empty($cart)): ?>
          <div class="empty-cart-container">
        <p class="empty-cart">Ωχ... Το καλάθι είναι άδειο <i class="fa-regular fa-face-frown"></i></p>
        <a href="shop.php" class="shop-link">Πίσω στο κατάστημα</a>
    </div>

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
                    <td>
             <div class="qty-controls">
            
                    <!-- plus button -->
                    <a href="update_cart.php?id=<?php echo $product['id']; ?>&action=decrease" class="qty-btn"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="qty-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        </svg>
                     </a>

                     <span class="qty-number"><?php echo $qty; ?></span>
                    
                     <!-- minus button -->
                    <a href="update_cart.php?id=<?php echo $product['id']; ?>&action=increase" class="qty-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="qty-icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </a>

                    <!-- delete button -->
                    <a href="update_cart.php?id=<?php echo $product['id']; ?>&action=remove" class="qty-btn delete-btn"  onclick="return confirm('Να αφαιρεθεί το προϊόν από το καλάθι;')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="qty-icon delete-btn">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>

                    </a>
            </div>
                </td>
                    <td>€<?php echo number_format($sum, 2); ?></td>
                </tr>
                <?php endforeach; ?>

                 <tr class="total-row">
                    <td colspan="4">
                        <div class="total-row-content">
                            <span class="total-label">Σύνολο</span>
                            <span class="total-amount">€<?php echo number_format($total, 2); ?></span>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- checkout button -->
            <div class="checkout-button">
                <a href="checkout.php">
                <button type="button">Ολοκλήρωση Αγοράς</button>
                </a>
            </div>

        <?php endif; ?>

    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>


</body>
</html>
