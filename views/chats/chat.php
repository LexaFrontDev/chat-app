<?php
include_once "../../controller/chats/chatController.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link rel="stylesheet" href="../styles/css/index.css">
</head>
<body>

<div class="nav-list">
    <a class="exit-button" href="/index.php">Выйти</a>
    <h1 class="headChat">Чат: <?= htmlspecialchars($chat['chat_name'] ?? 'Название отсутствует') ?></h1>

    <?php if ($currentUserId && $creatorUserId && $currentUserId === $creatorUserId): ?>
        <form class="deleteChat" action="../../controller/chats/DeleteChat.php" method="post" style="margin-bottom: 20px;">
            <input class="deleteChatButton" type="hidden" name="chat_id" value="<?= htmlspecialchars($chatId) ?>">
            <button type="submit" class="deleteChatButton" onclick="return confirm('Вы уверены, что хотите удалить этот чат?')">Удалить чат</button>
        </form>
    <?php endif; ?>
</div>



<div class="wrap-messages">
    <?php foreach ($messages as $message): ?>
        <div class="<?= $currentUsername === $message['username'] ? 'my-message' : 'other-message' ?>">
            <h3 class="nameUser"><?= htmlspecialchars($message['username']) ?>:</h3>
            <p class="messageUser"><?= htmlspecialchars($message['message']) ?></p>

            <?php if ($currentUsername && $currentUsername === $message['username']): ?>
                <button onclick="showEditForm('edit-form-<?= htmlspecialchars($message['id']) ?>')">Изменить</button>

                <form id="edit-form-<?= htmlspecialchars($message['id']) ?>" class="edit-form" action="../../controller/chats/UpdateHandler.php" method="post">
                    <input type="hidden" name="chat_id" value="<?= htmlspecialchars($chatId) ?>">
                    <input type="hidden" name="message_id" value="<?= htmlspecialchars($message['id']) ?>">
                    <input type="text" name="new_message" value="<?= htmlspecialchars($message['message']) ?>" required>
                    <input type="hidden" name="action" value="update">
                    <button type="submit">Сохранить</button>
                </form>


                <form action="../../controller/chats/DeleteHandler.php" method="post" style="display:inline;">
                    <input type="hidden" name="chat_id" value="<?= htmlspecialchars($chatId) ?>">
                    <input type="hidden" name="message_id" value="<?= htmlspecialchars($message['id']) ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Удалить</button>
                </form>
            <?php endif; ?>
        </div><br>
    <?php endforeach; ?>
</div>



<form action="../../controller/chats/SendHandler.php" method="post">
    <div class="messageWrap">
        <input type="hidden" name="chat_id" value="<?= htmlspecialchars($chatId) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($currentUserId) ?>">
        <textarea name="message" id="message" required></textarea>
        <input type="hidden" name="action" value="send">
        <button id="send" type="submit"> > </button>
    </div>
</form>


<script src="../../assets/scripts/editMessage.js"></script>
</body>
</html>

