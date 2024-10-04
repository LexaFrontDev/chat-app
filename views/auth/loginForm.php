<?php



include_once "../../controller/authController/do_login.php";
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
    <title>Войти</title>
</head>
<body>

<?php if (isset($errMsg)) { ?>
    <div style="font-family:sans-serif;color:#FF0000;text-align:center;font-size:17px;"><?php echo $errMsg; ?></div>
<?php } ?>

<div class="container">
    <div class="form_area">
        <p class="title">LOGIN</p>
        <form action="../../controller/authController/do_login.php" method="post">
            <div class="form_group">
                <label class="sub_title" for="username">Name</label>
                <input placeholder="Имя" id="username" class="form_style" type="text" name="name">
            </div>
            <div class="form_group">
                <label class="sub_title" for="useremail">Email</label>
                <input placeholder="Почта" id="useremail" class="form_style" type="email" name="email">
            </div>
            <div class="form_group">
                <label class="sub_title" for="userpassword">Password</label>
                <input placeholder="Пароль" id="userpassword" class="form_style" type="password" name="password">
            </div>
            <div>
                <button class="btn">Войти</button>
                <p>Нет аккаунта? <a class="link" href="./registrationForm.php">Зарегистрироваться здесь!</a></p>
            </div>
        </form>
    </div>
</div>


</body>
</html>
