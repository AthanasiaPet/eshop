<?php
session_start();
require_once "includes/db.php";
$sql = "
    SELECT products.*, categories.name AS category_name
    FROM products
    JOIN categories ON products.category_id = categories.id
";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Cat Shop</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<header>
    <h1> 
        <a href="index.php" class="logo">
        Cat Shop
        </a>
    </h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            
            <span>Καλώς ήρθες, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
            <a href="logout.php" class="logout-icon" title="Αποσύνδεση">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        
        <?php else: ?>
        
            <a href="login.php" class="user-icon" title="Σύνδεση">
                <i class="fa-regular fa-user"></i>
            </a>

        <?php endif; ?>
        <a href="cart.php" class="cart-icon" title="Καλάθι">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </nav>
</header>

<main>
    <h2>Προϊόντα για Γάτες</h2>

    <div class="products">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <img 
                src="images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                alt="<?php echo htmlspecialchars($product['name']); ?>"
            >

            <h3><?php echo htmlspecialchars($product['name']); ?></h3>

            <p><?php echo htmlspecialchars($product['description']); ?></p>

            <p class="price">
                €<?php echo number_format($product['price'], 2); ?>
            </p>

            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="add-cart-btn">
                Προσθήκη στο καλάθι
            </a>

        </div>
    <?php endforeach; ?>


</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>

</body>
</html>
