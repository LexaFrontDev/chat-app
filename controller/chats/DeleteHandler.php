<?php

require_once '../../model/config/Databaseconnect.php';

class DeleteHandler {
    private $conn;

    public function __construct() {
        $dbConnect = new DatabaseConnect();
        $this->conn = $dbConnect->getConnection();
    }

    private function logError($message) {
        error_log($message, 3, '../../logs/error.log');
    }

    private function logDebug($message) {
        error_log($message, 3, '../../logs/debug.log');
    }

    public function deleteMessage($chatId, $messageId) {
        if ($messageId) {
            $stmt = $this->conn->prepare("DELETE FROM messages WHERE id = :message_id");
            $stmt->bindParam(':message_id', $messageId);

            if ($stmt->execute()) {
                $this->logDebug("Сообщение удалено успешно");
                header("Location: ../../views/chats/chat.php?chat_id=$chatId&action=delete");
                exit();
            } else {
                $this->logError("Ошибка при удалении сообщения: " . json_encode($stmt->errorInfo()));
                echo "Ошибка при удалении сообщения. Попробуйте снова.";
                exit();
            }
        }
    }
}


$chatId = $_POST['chat_id'] ?? null;
$messageId = $_POST['message_id'] ?? null;

if ($chatId && $messageId) {
    $deleteHandler = new DeleteHandler();
    $deleteHandler->deleteMessage($chatId, $messageId);
} else {
    echo "Недостаточно данных для удаления сообщения.";
}

?>

