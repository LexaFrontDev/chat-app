<?php
require_once '../../model/config/DatabaseConnect.php';

class CreateChat
{
    private $conn;

    public function __construct() {
        $dbConnect = new DatabaseConnect();
        $this->conn = $dbConnect->getConnection();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->createChat();
        }
    }

    private function createChat() {
        $chatName = $_POST['chat_name'];
        $userIds = $_POST['user_ids'];
        $chatPassword = isset($_POST['chat_password']) && !empty($_POST['chat_password']) ? $_POST['chat_password'] : null;


        $username = $_COOKIE['username'];
        $creatorUserId = $this->getUserIdByUsername($username);

        if (!$creatorUserId) {
            echo "Пользователь не найден";
            return;
        }


        $chatId = $this->insertChat($chatName, $creatorUserId, $chatPassword);
        $this->addUsersToChat($chatId, $userIds);


        header("Location: /views/chats/chat.php?chat_id=$chatId");
        exit();
    }

    private function getUserIdByUsername($username) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['id'] : null;
    }

    private function insertChat($chatName, $creatorUserId, $chatPassword = null) {
        if ($chatPassword) {
            $stmt = $this->conn->prepare("INSERT INTO chats (chat_name, password, id_users, created_at) VALUES (:chat_name, :password, :id_users, NOW())");
            $chatPasswordHash = password_hash($chatPassword, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $chatPasswordHash);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO chats (chat_name, id_users, created_at) VALUES (:chat_name, :id_users, NOW())");
        }

        $stmt->bindParam(':chat_name', $chatName);
        $stmt->bindParam(':id_users', $creatorUserId);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    private function addUsersToChat($chatId, $userIds) {
        foreach ($userIds as $userId) {
            if (empty($userId) || !is_numeric($userId)) {
                continue;
            }
            $stmt = $this->conn->prepare("INSERT INTO messages (chat_id, id_user, message, created_at) VALUES (:chat_id, :id_user, '', NOW())");
            $stmt->bindParam(':chat_id', $chatId);
            $stmt->bindParam(':id_user', $userId);
            $stmt->execute();
        }
    }
}


$chatController = new CreateChat();
$chatController->handleRequest();