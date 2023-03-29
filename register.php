<?php
ini_set('session.save_path', "/var/www/html/session");
session_start();

$name=''; $login=''; $mail=''; $password=''; $passwordAgain='';     
//ЕСЛИ ПАРОЛИ НЕ СОВПАЛИ
if(!empty($_POST) && $_POST['password']!=$_POST['passwordAgain']){    
    $_SESSION['message']='errorPW';
    $name=$_POST['name']; $login=$_POST['login']; $mail=$_POST['mail']; $password=$_POST['password']; $passwordAgain=$_POST['passwordAgain'];
    //header('Location: /Project_Login_Register/register.php');    
    //exit;
}
//ПРОВЕРЯЕМ ЧТОБЫ В БД НЕ БЫЛО 2 ОДИНАКОВЫХ ЛОГИНОВ
require_once 'includes/connect.php';
if(!empty($_POST) && $_POST['password']==$_POST['passwordAgain']) {
    $result = mysqli_query($link, "SELECT * FROM `users` WHERE `Логин`='{$_POST['login']}'");   
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if(!empty($data)){                             
        $_SESSION['message']='errorLOG';       
        $name=$_POST['name']; $login=$_POST['login']; $mail=$_POST['mail']; $password=$_POST['password']; $passwordAgain=$_POST['passwordAgain'];
        //header('Location: /Project_Login_Register/register.php');
        //exit;
    }else{       
    $pw_hash=password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($link, "INSERT INTO `users` (`Имя`, `Логин`, `Почта`, `Пароль`) VALUES ('{$_POST['name']}', '{$_POST['login']}', '{$_POST['mail']}', '$pw_hash')");
    $_SESSION['message']='regend';         
    $_SESSION['login']=$_POST['login']; $_SESSION['password']=$_POST['password'];  
    header('Location: /Project_Login_Register/index.php');
    exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/Project_Login_Register/css/style.css" rel="stylesheet">
    <title>Регистрация</title>
</head>
<body>
<form class="register" action="" method="post">
    <label for="name">Имя</label>
    <input id="name" name="name" type="text" value="<?=$name?>">
    <label for="login">Логин</label>
    <input id="login" name="login" type="text" required value="<?=$login?>">
    <label for="mail">Почта</label>
    <input id="mail" name="mail" type="text" value="<?=$mail?>">
    <label for="password">Введите пароль</label>
    <input id="password" name="password" type="password" required value="<?=$password?>">
    <label for="passwordAgain">Подтвердите пароль</label>
    <input id="passwordAgain" name="passwordAgain" type="password" required value="<?=$passwordAgain?>">
    <?php
    if(!empty($_SESSION['message']) && $_SESSION['message']=='errorPW') {     
        echo '<p class="err">Пароли не совпадают!</p>';
        unset($_SESSION['message']); 
    }
    if(!empty($_SESSION['message']) && $_SESSION['message']=='errorLOG') {  
        echo '<p class="err">Логин уже занят!</p>';
        unset($_SESSION['message']);
    }

    ?>
    <input type="submit" class="button" value="Регистрация">
</form>
<p>Уже есть аккаунт? - <a href="index.php" ;">Войти</a></p>
</body>
</html>
