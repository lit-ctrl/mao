<?php  include_once "header.php"; ?>
<?php
require 'functions.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $patronymic = $_POST['patronymic'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "INSERT INTO users (name, surname, patronymic, login, email, password, role) VALUES (?, ?, ?, ?, ?, ?, 'client')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssss', $name, $surname, $patronymic, $login, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Ошибка: " . $stmt->error;
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Star - Название товара</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<main>
<div class="title">
    <h1>Регистрация</h1>
</div>
        <section class="registration">
            <?php if (isset($error)): ?>
                <p><?= $error ?></p>
                <?php endif; ?>
            <form action="register.php" method="post">
                <label for="surname">Фамилия:</label>
                <input type="text" name="surname" required>
                <label for="name">Имя:</label>
                <input type="text" name="name" required>
                <label for="dadname">Отчество:</label>
                <input type="dadname" id="dadname" name="dadname" required>
                <label for="login">Логин:</label>
                <input type="text" name="login" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="password">Пароль:</label>
                <input type="password" name="password" required>

                <label for="password_repeat">Повторите пароль:</label>
                <input type="password" name="password_repeat" required>
                <br>
                <label for="rules">Согласен с правилами регистрации:</label>
                <input type="checkbox" name="rules" required>
                <br>
                <button type="submit">Зарегистрироваться</button>
            </form>
        </section>
    </main>


<?php include_once "footer.php"; ?>