<?php  include_once "header.php"; ?>
<?php
session_start();

require 'functions.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['login'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Неверный пароль";
        }
    } else {
        $error = "Пользователь не найден";
    }

    $stmt->close();
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
    <h1>Вход</h1>
</div>
        <section class="login">
            <?php if (isset($error)): ?>
                <p><?= $error ?></p>
                <?php endif; ?>
            <form action="login.php" method="post">
            <label for="login">Логин:</label>
                <input type="name" placeholder="Логин" name="login" required>
            <label for="password">Пароль:</label> 
                <input type="password" placeholder="Пароль" name="password" required>
                <a href="index.php" class="ext"><button type="submit">Войти</a></button>
            </form>
        </section>
    </main>
</body>

<?php include_once "footer.php"; ?>