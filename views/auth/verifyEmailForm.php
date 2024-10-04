
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/css/index.css">
    <title>Подтверждение email</title>
</head>
<body>
<form class="codeVerfCont" action="../../controller/authController/verifyEmail.php" method="post">
    <input type="text" name="verification_code" class="input-style" placeholder="Введите код подтверждения"><br>
    <button type="submit">Подтвердить</button>
</form>
</body>
</html>

