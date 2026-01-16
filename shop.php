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

</head>
<body>

<header>
    <h1> 
        <a href="index.php" class="logo">
        Cat Shop
        </a>
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
