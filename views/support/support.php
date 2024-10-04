<?php
session_start();
require_once "../../model/config/Databaseconnect.php";
$db = new DatabaseConnect();
$conn = $db->getConnection();



$currentUsername = $_COOKIE['username'] ?? null;
$stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
$stmt->bindParam(':username', $currentUsername);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
$currentUserId = $currentUser ? $currentUser['id'] : null;


if (isset($_SESSION['errMsg'])) {
    $errMsg = $_SESSION['errMsg'];
    unset($_SESSION['errMsg']);
}

if (isset($_SESSION['succesMsg'])) {
    $succesMsg = $_SESSION['succesMsg'];
    unset($_SESSION['succesMsg']);
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/css/index.css">
    <title>Поддержка</title>
</head>
<body>

<?php if (isset($errMsg)) { ?>
    <div style="font-family:sans-serif;color:#FF0000;text-align:center;font-size:17px;"><?php echo $errMsg; ?></div>
<?php } ?>
<?php if (isset($succesMsg)) { ?>
    <div style="font-family:sans-serif;color:#0C7C59;text-align:center;font-size:17px;"><?php echo $succesMsg; ?></div>
<?php } ?>


<a class="exit"  href="../../index.php">Выйти</a>


<div class="form-container">
    <form class="form" method="post" action="../../controller/supportController/do_support.php">
        <input type="hidden" name="userId" value="<?=$currentUserId?>">
        <div class="form-group">
            <label for="support-input">Как мы можем вам помочь?</label>
            <textarea name="support" id="support-input" rows="10" cols="50" placeholder="Напишите проблему" required></textarea>
        </div>
        <button class="form-submit-btn" type="submit">Отправить</button>
    </form>
</div>

</body>
</html>

