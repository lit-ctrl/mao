<?php  include_once "header.php"; ?>

<?php
session_start();


if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    
    $new_product = [
        'id' => $product_id,
        'name' => $product_name,
        'description' => $product_description,
        'price' => $product_price
    ];


    $_SESSION['products'][] = $new_product;


    $success = "Товар успешно добавлен в корзину.";
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Название товара</title>
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
               <a href="product.php" class="watch">   <img src="img/print.png" ></a>
            </div>
            <div class="product">
                <h3>Характеристики:</h3>
                <p>Страна: Казахстан</p>
                <p>Год выпуска: 2024</p>
                <p>Модель: Да</p>
                <div class="price">
                    <p>Цена: <b>400$</b></p>
                </div>
                <div class="information">
                
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="1">
                        <input type="hidden" name="product_name" value="Товар">
                        <input type="hidden" name="product_description" value="Страна: Казахстан, Год выпуска: 2024, Модель: Да">
                        <input type="hidden" name="product_price" value="400">
                        <button type="submit" class="b-cart">Удалить</button>
                        <button type="submit" class="b-cart">В корзину</button>
                    </form>
                </div>
            </div>
        </section>


        
            
</body>

</html>


<?php include_once "footer.php"; ?>