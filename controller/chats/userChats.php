<?php
require_once __DIR__ . "/../../model/config/Databaseconnect.php";
require_once __DIR__ . "/../chats/MessageHandler.php";

$dbConnect = new DatabaseConnect();
$conn = $dbConnect->getConnection();
$messageHandler = new MessageHandler();

$currentUsername = $_COOKIE['username'] ?? null;
$currentUserId = null;
$chats = [];

if ($currentUsername) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->bindParam(':username', $currentUsername);
    $stmt->execute();
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentUserId = $currentUser ? $currentUser['id'] : null;

    if ($currentUserId) {
        $stmtChats = $conn->prepare("SELECT * FROM chats WHERE id_users = :id_users");
        $stmtChats->bindParam(':id_users', $currentUserId);
        $stmtChats->execute();
        $chats = $stmtChats->fetchAll(PDO::FETCH_ASSOC);
    }
}


echo "<script>let userChats = " . json_encode($chats) . ";</script>";
?>




