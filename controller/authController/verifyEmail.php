<?php
session_start();

if (isset($_POST['verification_code'])) {
    $userInputCode = $_POST['verification_code'];


    if ($userInputCode == $_SESSION['verification_code']) {

        $userData = $_SESSION['user_registration_data'];

        require_once __DIR__ . "/../../model/config/Databaseconnect.php";
        require_once __DIR__ . "/../../model/Users.php";

        $db = new DatabaseConnect();
        $conn = $db->getConnection();
        $user = new Users($conn);


        $result = $user->register($userData['name'], $userData['email'], $userData['password']);

        if ($result) {
            echo $result;
        } else {
            $_SESSION['errMsg'] = 'Ошибка при регистрации пользователя.';
            header('Location: ../../views/auth/registrationForm.php');
        }
    } else {
        $_SESSION['errMsg'] = 'Неверный код подтверждения.';
        header('Location: ../../views/auth/verifyEmailForm.php');
        exit();
    }
}
