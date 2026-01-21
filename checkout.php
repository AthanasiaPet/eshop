<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$ids = implode(",", array_keys($cart));
$sql = "SELECT * FROM products WHERE id IN ($ids)";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($products as $p) {
    $total += $p['price'] * $cart[$p['id']];
}


if (isset($_POST['checkout'])) {
    $pdo->beginTransaction();
    try {

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $orderId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($products as $p) {
            $stmt->execute([
                $orderId,
                $p['id'],
                $cart[$p['id']],
                $p['price']
            ]);
        }
         unset($_SESSION['cart']);

        $pdo->commit();

    
        header("Location: success.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Κάτι πήγε στραβά: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Cat Shop</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/checkout.css">

</head>
<body>
<header>
    <h1><a href="index.php" class="logo">Cat Shop</a></h1>
    <nav>
        <a href="cart.php" class="cart-icon">Καλάθι</a>
        <a href="logout.php" class="user-icon">Logout</a>
    </nav>
</header>

<main class="center-page">
    <div class="center-box cart-box">
        <h2>Checkout</h2>

        <table class="cart-table">
            <tr>
                <th>Προϊόν</th>
                <th>Τιμή</th>
                <th>Ποσότητα</th>
                <th>Σύνολο</th>
            </tr>
            <?php foreach ($products as $p): 
                $qty = $cart[$p['id']];
                $sum = $p['price'] * $qty;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($p['name']); ?></td>
                <td>€<?php echo number_format($p['price'],2); ?></td>
                <td><?php echo $qty; ?></td>
                <td>€<?php echo number_format($sum,2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="3"><strong>Σύνολο</strong></td>
                <td><strong>€<?php echo number_format($total,2); ?></strong></td>
            </tr>
        </table>

        <h3>Στοιχεία Πληρωμής</h3>
        <form method="post" class="payment-form">
            <label>Όνομα Κατόχου</label>
            <input type="text" name="card_name" required>

            <label>Αριθμός Κάρτας</label>
            <input type="text" name="card_number" required>

            <div class="row">
            <div class="col">
                <label>Ημ/νία Λήξης</label>
                <input type="text" name="expiry" required>
            </div>
            <div class="col">
                <label>CVV</label>
                <input type="text" name="cvv" required>
            </div>
            </div>

            <button type="submit" name="checkout">Πληρωμή</button>
        </form>

    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>
</body>
</html>
