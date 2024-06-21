<?php  include_once "header.php"; ?>

<?php session_start();

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
    <title>Корзина</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
     <div class="title">
    <h1> Ваша Корзина</h1>
</div>
<div class="mai">
        <?php if (isset($success)) echo '<p style="color:green;">' . htmlspecialchars($success) . '</p>'; ?>

       

        <section class="cart">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Название товара</th>
                    <th>Описание</th>
                    <th>Цена</th>
                </tr>
                <?php foreach ($_SESSION['products'] as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $product['price'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </div>
</body>

</html>



<?php include_once "footer.php"; ?>