<?php

require_once '../../model/config/Databaseconnect.php';

class UpdateHandler {
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

    public function updateMessage($chatId, $messageId, $newMessage) {
        if ($messageId && $newMessage) {
            $stmt = $this->conn->prepare("UPDATE messages SET message = :new_message WHERE id = :message_id");
            $stmt->bindParam(':new_message', $newMessage);
            $stmt->bindParam(':message_id', $messageId);

            if ($stmt->execute()) {
                $this->logDebug("Сообщение обновлено успешно");
                header("Location: ../../views/chats/chat.php?chat_id=$chatId&action=update");
                exit();
            } else {
                $this->logError("Ошибка при обновлении сообщения: " . json_encode($stmt->errorInfo()));
                echo "Ошибка при обновлении сообщения. Попробуйте снова.";
                exit();
            }
        }
    }
}


$chatId = $_POST['chat_id'] ?? null;
$messageId = $_POST['message_id'] ?? null;
$newMessage = $_POST['new_message'] ?? null;

if ($chatId && $messageId && $newMessage) {
    $updateHandler = new UpdateHandler();
    $updateHandler->updateMessage($chatId, $messageId, $newMessage);
} else {
    echo "Недостаточно данных для обновления сообщения.";
}

?>

