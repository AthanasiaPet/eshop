<?php
session_start();

if (!isset($_GET['id'], $_GET['action'])) {
    header("Location: cart.php");
    exit;
}

$id = (int) $_GET['id'];
$action = $_GET['action'];

if (!isset($_SESSION['cart'][$id])) {
    header("Location: cart.php");
    exit;
}

switch ($action) {
    case 'increase':
        $_SESSION['cart'][$id]++;
        break;

    case 'decrease':
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
        break;

    case 'remove':
        unset($_SESSION['cart'][$id]);
        break;
}

header("Location: cart.php");
exit;
