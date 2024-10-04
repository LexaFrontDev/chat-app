<?php
require_once '../../model/config/DatabaseConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat_id'])) {
    $chatId = $_POST['chat_id'];


    $dbConnect = new DatabaseConnect();
    $conn = $dbConnect->getConnection();

    $stmt = $conn->prepare("SELECT id_users FROM chats WHERE id = :chat_id");
    $stmt->bindParam(':chat_id', $chatId);
    $stmt->execute();
    $chat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chat) {

        $creatorUserId = $chat['id_users'];


        $currentUsername = $_COOKIE['username'] ?? null;
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $currentUsername);
        $stmt->execute();
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentUserId = $currentUser ? $currentUser['id'] : null;


        if ($currentUserId === $creatorUserId) {

            $stmt = $conn->prepare("DELETE FROM messages WHERE chat_id = :chat_id");
            $stmt->bindParam(':chat_id', $chatId);
            $stmt->execute();


            $stmt = $conn->prepare("DELETE FROM chats WHERE id = :chat_id");
            $stmt->bindParam(':chat_id', $chatId);
            $stmt->execute();


            header("Location: ../../index.php");
            exit();
        } else {
            echo "Ошибка: У вас нет прав для удаления этого чата.";
        }
    } else {
        echo "Ошибка: Чат не найден.";
    }
} else {
    echo "Ошибка: Неверный запрос.";
}
?>

