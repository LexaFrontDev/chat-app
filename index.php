<?php

require_once "controller/chats/userChats.php";


$isLoggedIn = isset($_COOKIE['username']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="views/styles/css/index.css">
</head>
<body>

<div class="nav-home">
    <ul class="nav-list">
        <?php if ($isLoggedIn): ?>
            <li class="nav-item user-name">Имя, <?php echo htmlspecialchars($_COOKIE['username']); ?>!</li>
            <li class="nav-item"><a class="exit-l" href="/controller/authController/logour.php">Выйти</a></li>
            <li class="nav-item"><a class="st-l" href="index.php">Главная</a></li>
            <li class="nav-item"><a class="st-l" href="views/chats/chatsMain.php">Чаты</a></li>
            <li class="nav-item"><a class="st-l" href="views/support/support.php">Поддержка</a></li>




        <?php else: ?>
            <li class="nav-item reg"><a href="views/auth/registrationForm.php">Зарегистрироваться</a></li>
            <p>|</p>
            <li class="nav-item log"><a href="views/auth/loginForm.php">Войти</a></li>
        <?php endif; ?>


    </ul>
</div>

<script src="assets/scripts/search.js"></script>

</body>
</html>
