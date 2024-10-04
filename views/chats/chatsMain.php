<?php
require_once '../../model/config/DatabaseConnect.php';
require_once '../../model/get/GetData.php';

$dbConnect = new DatabaseConnect();
$getData = new GetData($dbConnect);
$chats = $getData->fetchData('chats');



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Чаты</title>
    <link rel="stylesheet" href="../../views/styles/css/index.css">
</head>
<body>

<div class="nav-container">
    <ul class="nav-chat-list">
       <button class="navButtonLink"><a class="nav-chats-item link-home" href="/index.php">Главная</a></button>
        <button class="nav-chats-item  createChat nav-button">Создать чат</button>
        <input type="search" placeholder="Найти чат" name="findChats" class="nav-chats-item  search-chats" onkeyup="searchChat();">
    </ul>


</div>

<div class="container-chats">
    <?php foreach ($chats as $chat): ?>
        <div class="chat">

            <div class="wrap-chat-info">
                <p class="chat_id">ID: <?= htmlspecialchars($chat['id']) ?></p>
                <p class="chats-name">Name: <?= htmlspecialchars($chat['chat_name']) ?></p>
            </div>

            <?php if (!empty($chat['password'])): ?>
                <form  action="/views/chats/chat.php" method="POST">
                    <input type="hidden" name="chat_id" value="<?= htmlspecialchars($chat['id']) ?>">
                    <input type="password" name="chat_password" placeholder="Введите пароль для чата" required><br>
                    <button type="submit">Войти</button>
                    <div class="line"></div>
                </form>

            <?php else: ?>
                <button><a href="/views/chats/chat.php?chat_id=<?= htmlspecialchars($chat['id']) ?>">Войти</a></button>
            <?php endif; ?>
        </div>


    <?php endforeach; ?>
</div>

<p class="error hidden">Нет такого чата</p>

<script src="../../assets/scripts/search.js"></script>
<script src="../../assets/scripts/modalCreater.js"></script>
</body>
</html>
