<?php
ini_set('session.save_path', "/var/www/html/session");
session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/Project_Login_Register/css/style.css" rel="stylesheet">
    <title>Вход</title>
</head>
<body>
<form action="signin.php", method="post">
    <?php
    $login=''; $password='';            //дефолтное значение value в инпутах
    if(!empty($_SESSION['login']) && !empty($_SESSION['password'])){    //если в сешон есть логин и пароль, то заносим логин и пароль в value в инпутах
        $login=$_SESSION['login']; $password=$_SESSION['password'];}
    echo "<input type='text' placeholder='Логин' name='login' required value='{$login}'>";
    echo "<input type='password' placeholder='Пароль' name='password' required value='{$password}'>";
    if((!empty($_SESSION['message']) && $_SESSION['message']=='regend')){
        echo '<p class="reg">Регистрация прошла успешно!</p>';
        unset($_SESSION['message']); unset($_SESSION['login']); unset($_SESSION['password']); $login=''; $password='';    
    }
    if(!empty($_SESSION['message']) && $_SESSION['message']=='errorIN'){
        echo '<p class="err">Вы не зарегистрированы!</p>';
        unset($_SESSION['message']);
    }
    if(!empty($_SESSION['message']) && $_SESSION['message']=='errorINPW'){
        echo '<p class="err">Неверный пароль!</p>';
        unset($_SESSION['message']);
    }
    ?>

    <input type="submit" class="button" value="Войти">
</form>
<p>Нет аккаунта? - <a href="register.php">Регистрация</a><p>
</body>
</html>
