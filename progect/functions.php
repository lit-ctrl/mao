<?php
session_start();
require 'db.php';


function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isClient() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'client';
}

function isLoggedIn() {
    return isset($_SESSION['username']);
}

function redirectIfNotAdmin() {
    if (!isAdmin()) {
        header("Location: index.php");
        exit();
    }
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function getCart() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

function addToCart($product_id) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    global $conn;
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error in preparing statement: ' . $conn->error);
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
                'stock' => $product['count']
            ];
        }
    } else {
        die('Product not found.');
    }

    $stmt->close();
}

function updateCartQuantity($product_id, $quantity) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
}

function removeFromCart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

function clearCart() {
    unset($_SESSION['cart']);
}

function calculateCartTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

function createOrder($user_id, $cart) {
    global $conn;

    $status = 'pending';
    $query = "INSERT INTO orders (user_id, status) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();

    if ($stmt->errno) {
        return false;
    }

    $order_id = $stmt->insert_id;
    $stmt->close();

    foreach ($cart as $product_id => $item) {
        $quantity = $item['quantity'];
        $query = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $order_id, $product_id, $quantity);
        $stmt->execute();
        if ($stmt->errno) {
            return false;
        }
        $stmt->close();
    }

    return $order_id;
}

function validatePassword($user_id, $password) {
    global $conn;
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("SQL Error: " . $conn->error);
        return false;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!$hashed_password) {
        return false;
    }

    return password_verify($password, $hashed_password);
}
?>
