<?php
session_start();

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$product_id = (int) $_GET['id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]++;
} else {
    $_SESSION['cart'][$product_id] = 1;
}

header("Location: shop.php");
exit;
