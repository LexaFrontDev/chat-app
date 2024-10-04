<?php

require_once '../../model/config/DatabaseConnect.php';
require_once '../../controller/chats/MessageHandler.php';

$currentUsername = $_COOKIE['username'] ?? null;
$currentUserId = null;

if ($currentUsername) {
    $dbConnect = new DatabaseConnect();
    $conn = $dbConnect->getConnection();

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->bindParam(':username', $currentUsername);
    $stmt->execute();
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUserId = $currentUser ? $currentUser['id'] : null;
}

$messageHandler = new MessageHandler();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['chat_id'])) {
    $chatId = $_GET['chat_id'];
    $chat = $messageHandler->getChat($chatId);
    $messages = $messageHandler->getMessages($chatId);

    if (!$chat) {
        echo "<h1>Чат не найден.</h1>";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat_id'], $_POST['chat_password'])) {
    $chatId = $_POST['chat_id'];
    $chatPassword = $_POST['chat_password'];

    if (!$messageHandler->validateChatPassword($chatId, $chatPassword)) {
        echo "<p>Ошибка: неверный пароль.</p>";
        exit();
    }

    $chat = $messageHandler->getChat($chatId);
    $messages = $messageHandler->getMessages($chatId);
} else {
    echo "<p>Ошибка: неверный запрос.</p>";
    exit();
}

$creatorUserId = $chat['id_users'] ?? null;
