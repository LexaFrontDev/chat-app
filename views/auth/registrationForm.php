<?php

include_once "../../controller/authController/do_register.php";
session_start();
if (isset($_SESSION['errMsg'])) {
    $errMsg = $_SESSION['errMsg'];
    unset($_SESSION['errMsg']);
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
    <title>Зарегестрироваться</title>
</head>
<body>
<?php if (isset($errMsg)) { ?>
    <div style="font-family:sans-serif;color:#FF0000;text-align:center;font-size:17px;"><?php echo $errMsg; ?></div>
<?php } ?>




<div class="container">
    <div class="form_area">
        <p class="title">SIGN UP</p>
        <form class="contForm" action="../../controller/authController/do_register.php" method="post">
            <div class="form_group">
                <label class="sub_title" for="username">Name</label>
                <input placeholder="Введите имя" id="username" class="form_style inputAuth" type="text" name="username">
            </div>
            <div class="form_group">
                <label class="sub_title" for="useremail">Email</label>
                <input placeholder="Введите email" id="useremail" class="form_style inputAuth" type="email" name="useremail">
            </div>
            <div class="form_group">
                <label class="sub_title" for="userpassword">Password</label>
                <input placeholder="Введите пароль" id="userpassword" class="form_style inputAuth" type="password" name="userpassword">
            </div>
            <div>
                <button type="submit" class="btn">Зарегистрироваться</button>
                <p>Уже есть аккаунт? <a class="link" href="./loginForm.php">Войти здесь!</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>

