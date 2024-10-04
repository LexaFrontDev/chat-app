<?php

session_start();
require_once __DIR__ . "/../../model/config/Databaseconnect.php";
require_once __DIR__ . "/../../model/Users.php";
$db = new DatabaseConnect();
$conn = $db->getConnection();
$user = new Users($conn);


if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $result = $user->login($name, $email, $password);

    if ($result) {
        echo $result;
    }
}