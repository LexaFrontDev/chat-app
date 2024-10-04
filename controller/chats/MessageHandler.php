<?php

require_once __DIR__ . "/../../model/config/Databaseconnect.php";

class MessageHandler {
    private $conn;

    public function __construct() {
        $dbConnect = new DatabaseConnect();
        $this->conn = $dbConnect->getConnection();
    }

    public function getChat($chatId) {
        $stmt = $this->conn->prepare("SELECT * FROM chats WHERE id = :chat_id");
        $stmt->bindParam(':chat_id', $chatId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMessages($chatId) {
        $stmt = $this->conn->prepare("
        SELECT messages.*, users.username 
        FROM messages 
        JOIN users ON messages.id_user = users.id 
        WHERE messages.chat_id = :chat_id 
        ORDER BY messages.created_at ASC
    ");
        $stmt->bindParam(':chat_id', $chatId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


//    public function updateMessage($messageId, $newMessage) {
//        $stmt = $this->conn->prepare("UPDATE messages SET message = :new_message WHERE id = :message_id");
//        $stmt->bindParam(':new_message', $newMessage);
//        $stmt->bindParam(':message_id', $messageId);
//        return $stmt->execute();
//    }
//
//    public function deleteMessage($messageId) {
//        $stmt = $this->conn->prepare("DELETE FROM messages WHERE id = :message_id");
//        $stmt->bindParam(':message_id', $messageId);
//        return $stmt->execute();
//    }

    public function validateChatPassword($chatId, $chatPassword) {
        $chat = $this->getChat($chatId);
        if (!empty($chat['password']) && !password_verify($chatPassword, $chat['password'])) {
            return false;
        }
        return true;
    }
}
