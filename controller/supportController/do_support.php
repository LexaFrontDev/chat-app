<?php
session_start();
require_once "../../model/config/Databaseconnect.php";
$db = new DatabaseConnect();
$conn = $db->getConnection();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId'], $_POST['support'])) {
        $userId = htmlspecialchars($_POST['userId']);
        $problem = htmlspecialchars($_POST['support']);


        try{
            $insertSupportUser = $db->insert('INSERT INTO support (id_user, supportText) VALUES (:useriD, :userProblem)', [':useriD' => $userId, ':userProblem' => $problem]);
            $_SESSION['succesMsg'] = 'Ваш запрос успешно отправлен в службу поддержки. Мы свяжемся с вами в ближайшее время. Спасибо за обращение! ';
            header('Location: ../../views/support/support.php');
            exit();
        }catch (PDOException $e){
            $_SESSION['errMsg'] = 'Ващ запрос не отправлени в поддержку, попробуйте еще раз. ';
            header('Location: ../../views/support/support.php');
            exit();
        }




    } else {
        echo "Поля userId и support не установлены.";
    }
}
