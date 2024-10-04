<?php
session_start();



require_once __DIR__ . "/../../model/config/Databaseconnect.php";
require_once __DIR__ . "/../../model/Users.php";

function sendVerificationEmail($email, $code) {
    $subject = "Код подтверждения регистрации";
    $message = "Ваш код подтверждения: " . $code;
    $headers = "From: no-reply@yourwebsite.com";
    mail($email, $subject, $message, $headers);
}

$db = new DatabaseConnect();
$conn = $db->getConnection();
$user = new Users($conn);

if (isset($_POST['username']) && isset($_POST['useremail']) && isset($_POST['userpassword'])) {
    $name = $_POST['username'];
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['errMsg'] = 'Заполните все поля';
        header('Location: ../../views/auth/registrationForm.php');
        exit();
    } else if (strlen($name) < 5) {
        $_SESSION['errMsg'] = 'Имя пользователя не должно быть меньше 5 букв';
        header('Location: ../../views/auth/registrationForm.php');
        exit();
    } else if (!preg_match('/\d/', $password)) {
        $_SESSION['errMsg'] = 'Пароль должен содержать хотя бы одну цифру.';
        header('Location: ../../views/auth/registrationForm.php');
        exit();
    }


    $verificationCode = rand(100000, 999999);


    $_SESSION['verification_code'] = $verificationCode;
    $_SESSION['user_registration_data'] = ['name' => $name, 'email' => $email, 'password' => $password];


    sendVerificationEmail($email, $verificationCode);

    header('Location: ../../views/auth/verifyEmailForm.php');
    exit();
}
