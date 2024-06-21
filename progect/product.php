<?php  include_once "header.php"; ?>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];

    $_SESSION['products'][] = [
        'id' => $productId,
        'name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice
    ];
    $success = "Товар успешно добавлен в корзину.";
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Star - Название товара</title>
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <main>
    <?php if (isset($success)) echo '<p style="color:green;">' . htmlspecialchars($success) . '</p>'; ?>

    <div class="title">
    <h1>Название товара</h1>
    </div>
    <section class="catalog">
        <div class="imges">
            <img src="img/print.png" alt="Товар"></div>
            <div class="product">
                <h3>Характеристики:</h3>
                <p>Страна: Казахстан</p>
                <p>Год выпуска: 2024</p>
                <p>Модель: Да</p>
                <div class="price"><p>Цена: <b>400$<b></p></div>
                <div class="information">
            
                <form method="POST" action="cart.php">
                     <input type="hidden" name="product_id" value="1">
                     <input type="hidden" name="product_name" value="Название товара">
                     <input type="hidden" name="product_description" value="Страна: Казахстан, Год выпуска: 2024, Модель: Да">
                      <input type="hidden" name="product_price" value="400">
                      <button type="submit" class="b-cart">Удалить</button>
                      <button type="submit" class="b-cart">В корзину</button>
                </form>
                </div>
            </div>
        
    </section>
    </main>

</body>

</html>

<?php include_once "footer.php"; ?>