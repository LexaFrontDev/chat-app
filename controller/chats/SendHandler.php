<?php




require_once '../../model/config/Databaseconnect.php';

class SendHandler {
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

    public function sendMessage($chatId, $userId, $message) {
        if ($message) {
            $stmt = $this->conn->prepare("INSERT INTO messages (chat_id, id_user, message, created_at) VALUES (:chat_id, :id_user, :message, NOW())");
            $stmt->bindParam(':chat_id', $chatId);
            $stmt->bindParam(':id_user', $userId);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
                $this->logDebug("Сообщение отправлено успешно");
                $this->logDebug("Перед выполнением header");
                header("Location: ../../views/chats/chat.php?chat_id=$chatId&action=send");
                $this->logDebug("После выполнения header");
                exit();
            } else {
                $this->logError("Ошибка при отправке сообщения: " . json_encode($stmt->errorInfo()));
                echo "Ошибка при отправке сообщения. Попробуйте снова.";
                exit();
            }
        }
    }
}


$chatId = $_POST['chat_id'] ?? null;
$userId = $_POST['user_id'] ?? null;
$message = $_POST['message'] ?? null;

if ($chatId && $userId && $message) {
    $sendHandler = new SendHandler();
    $sendHandler->sendMessage($chatId, $userId, $message);
} else {
    echo "Недостаточно данных для отправки сообщения.";
}

?>


