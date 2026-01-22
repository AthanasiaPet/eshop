<?php
session_start();
require_once "includes/db.php";


$products = $pdo->query("
    SELECT p.*, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
    ORDER BY c.id
")->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$categoryFilter = $_GET['category'] ?? null;

$sql = "
    SELECT p.*, c.name AS category_name
    FROM products p
    JOIN categories c ON p.category_id = c.id
";

if ($categoryFilter) {
    $sql .= " WHERE c.id = ?";
}

$sql .= " ORDER BY c.id";

$stmt = $pdo->prepare($sql);

if ($categoryFilter) {
    $stmt->execute([$categoryFilter]);
} else {
    $stmt->execute();
}

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
            
            <span class="welcome-msg">Καλώς ήρθες, <?= htmlspecialchars($_SESSION['user_name']) ?>!</span>
            <a href="logout.php" class="logout-icon" title="Αποσύνδεση">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        
        <?php else: ?>
        
            <a href="login.php" class="user-icon" title="Σύνδεση">
                <i class="fa-regular fa-user"></i>
            </a>

        <?php endif; ?>
    <div class="dropdown">
            <a href="#" class="dropdown-toggle" style="color: white; font-size: 20px;" title="Κατηγορίες">
                <i class="fa-solid fa-bars"></i>
            </a>

        <div class="dropdown-menu">
            <a href="shop.php"><b>Όλα τα προϊόντα</b></a>

            <?php foreach ($categories as $cat): ?>
                <a href="shop.php?category=<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

        

        <a href="cart.php" class="cart-icon" title="Καλάθι">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </nav>
</header>

<main>
    <h2>Προϊόντα για Γάτες</h2>

    <?php
    $currentCategory = '';

    foreach ($products as $product):

        if ($currentCategory !== $product['category_name']):
            if ($currentCategory !== '') echo '</div>';
         $currentCategory = $product['category_name'];
        ?>
        <h3 class="category-title">
            <?= htmlspecialchars($currentCategory) ?>
        </h3>
        
        <div class="products">
        <?php endif; ?>

            <div class="product">
                <img 
                    src="images/products/<?= htmlspecialchars($product['image']); ?>" 
                    alt="<?= htmlspecialchars($product['name']); ?>"
                >

                <h4><?= htmlspecialchars($product['name']); ?></h4>

                <p><?= htmlspecialchars($product['description']); ?></p>

                <p class="price">
                    €<?= number_format($product['price'], 2); ?>
                </p>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="add_to_cart.php?id=<?= $product['id']; ?>" class="add-cart-btn">
                        Προσθήκη στο καλάθι
                    </a>
                <?php else: ?>
                    <a href="login.php" class="add-cart-btn">
                    Προσθήκη στο καλάθι
                    </a>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>
</main>

<footer>
    <p>&copy; 2026 Cat Shop</p>
</footer>

<script>
    const toggle = document.querySelector('.dropdown-toggle');
    const menu = document.querySelector('.dropdown-menu');

    
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    });

    
    window.addEventListener('click', function(e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });
</script>
</body>
</html>
